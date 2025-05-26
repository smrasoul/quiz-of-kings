<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Game;
use App\Models\MatchmakingQueue;
use App\Models\Question;
use App\Models\RandomCategories;
use App\Models\Round;
use App\Models\RoundAnswer;
use Illuminate\Support\Facades\Auth;
use App\Models\RoundQuestion;
use function PHPUnit\Framework\isNull;

class GameController extends Controller
{

    //check if the player is already in a game or queue
    //player can post a form to be added to the queue (queue method)
    //or be redirected to /game/{game} (show method)
    public function index(){

        $user = Auth::id();

        $games = Game::where(function ($query) {
            $query->where('player_one_id', Auth::id())
                ->orWhere('player_two_id', Auth::id());
        })->where('status', '!=', 'completed')->get();


        return view('games.index', compact('games'));
    }


    //adds the player to the queue
    public function queue(){

        MatchmakingQueue::create([
            'user_id' => Auth::user()->id,
        ]);

        return redirect('/games');

    }

    //shows the overall progress of a game
    //if it's the players turn, they're redirected to /game/{game}/round/{round} to choose a category.
    public function show(Game $game){


        $rounds = Round::where('game_id', $game->id)->get();

        $userId = Auth::id();

        return view('games.show', compact('game', 'rounds', 'userId'));

    }

    public function createRoundQuestion(Game $game, Round $round)
    {
        if($round->category_id !== null){
            return redirect('/game/'.$game->id.'/round/'.$round->id.'/question');
        }

        $randomCategories = RandomCategories::with('category')
            ->where('round_id', $round->id)
            ->get();

        if ($randomCategories->isEmpty()) {

            //Get category_ids already used in the rounds table
            $alreadyUsedCategoryIds = Round::whereNotNull('category_id')
                ->pluck('category_id')
                ->unique(); // optional, but safe

            //Exclude those from the new random selection
            $categories = Category::whereNotIn('id', $alreadyUsedCategoryIds)
                ->inRandomOrder()
                ->limit(3)
                ->get();


            foreach ($categories as $category) {
                RandomCategories::create([
                    'round_id' => $round->id,
                    'category_id' => $category->id,
                ]);
            }

            // Re-fetch with eager-loaded category relationship
            $randomCategories = RandomCategories::with('category')
                ->where('round_id', $round->id)->get();
        }



        return view('games.round', compact('randomCategories'));
    }

    public function storeRoundQuestion(Game $game, Round $round)
    {

        if($round->category_id !== null){
            return redirect('/game/'.$game->id.'/round/'.$round->id.'/question');
        }

        //validate the selected category
        $category_id = request()->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id']
        ])['category_id'];


        //Check for cheating in supplying wrong category ID
        $randomCategories = RandomCategories::with('category')
            ->where('round_id', $round->id)->get();

        $existsInRound = $randomCategories->contains('category_id', $category_id);

        if(!$existsInRound){
            abort(403, 'stop cheating dude.');
        }



        //update the category of the current round
        $round->update(['category_id' => $category_id]);


        //pick random questions from the selected category
        $questions = Question::where('category_id', $category_id)
            ->inRandomOrder()
            ->take(3)
            ->get();
        //add the question to the round_questions table
        foreach ($questions as $index => $question) {
            RoundQuestion::create([
                'round_id' => $round->id,
                'question_id' => $question->id,
                'order' => $index + 1,
            ]);
        }

        return redirect('/game/'.$game->id.'/round/'.$round->id.'/question');

    }

    public function showQuestion(Game $game, Round $round)
    {

        $answersCount = RoundAnswer::where('round_id', $round->id)
            ->where('user_id', Auth::id())->count();

        if($answersCount > 2) {
            return redirect('/game/'.$game->id);
        }

        $question = $round->roundQuestions()
            ->where('order', $answersCount + 1)
            ->firstOrFail()
            ->question;

        $questionOptions = $question->questionOptions()->get();

        return view('games.question',
            compact('question', 'questionOptions'));
    }

    public function storeQuestion(Game $game, Round $round)
    {

        $roundAnswer = request()->validate([
            'selected_option_id' => ['required', 'integer']
        ])['selected_option_id'];

        $answersCount = RoundAnswer::where('round_id', $round->id)
            ->where('user_id', Auth::id())->count();

        $question = $round->roundQuestions()
            ->where('order', $answersCount + 1)
            ->firstOrFail()
            ->question;

        $isCorrect = $question->questionOptions
            ->findOrFail($roundAnswer)
            ->is_correct;

        RoundAnswer::create([

            'round_id' => $round->id,
            'question_id' => $question->id,
            'user_id' => Auth::id(),
            'selected_option_id' => $roundAnswer,
            'is_correct' => $isCorrect,
            'answered_at' => now(),

        ]);

        //flip the turns.

        $currentRoundNumber = $round->round_number; // or whatever field stores this

        if (($currentRoundNumber % 2 === 1 && $game->current_turn === $game->player_one_id) ||
            ($currentRoundNumber % 2 === 0 && $game->current_turn === $game->player_two_id)) {

            $game->current_turn = $game->player_one_id === $game->current_turn
                ? $game->player_two_id
                : $game->player_one_id;

            $game->save();
        }

        if (RoundAnswer::where('round_id', $round->id)->count() === 6) {
            $round->update([
                'status' => 1
            ]);
        }

        if (RoundAnswer::where('round_id', $round->id)->count() === 6 &&
            Round::where('game_id', $game->id)->count() < 4) {

            Round::create([
                'game_id' => $game->id,
                'round_number' => $round->round_number + 1,
                'started_at' => now()
            ]);

        } //elseif(RoundAnswer::where('round_id', $round->id)->count() === 6 &&
        //         Round::where('game_id', $game->id)->count() = 4)
        {

            //mark the game as completed

            //Show the winner

        }


        return redirect("/game/$game->id/round/$round->id/question");

    }





}
