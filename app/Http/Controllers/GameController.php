<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Game;
use App\Models\MatchmakingQueue;
use App\Models\Question;
use App\Models\Round;
use App\Models\RoundAnswer;
use Illuminate\Support\Facades\Auth;
use App\Models\RoundQuestion;

class GameController extends Controller
{

    //check if the player is already in a game or queue
    //player can post a form to be added to the queue (queue method)
    //or be redirected to /game/{game} (show method)
    public function index(){

        $user = Auth::user();

        $queued = MatchmakingQueue::where('user_id', $user )->first();

        $game = Game::where(function ($query) {
            $query->where('player_one_id', Auth::id())
                ->orWhere('player_two_id', Auth::id());
        })->where('status', '!=', 'completed')->first();


        return view('games.index', ['queued' => $queued,
            'game' => $game]);
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

        $round = Round::where('game_id', $game->id)->latest()->first();

        $userId = Auth::id();

        return view('games.show',
            [
            'game' => $game,
            'round' => $round,
            'userId' => $userId
            ]
        );
    }

    public function selectCategory(Game $game, Round $round)
    {

//        if($round->category){
//
//        }

        $categories = Category::inRandomOrder()->limit(3)->get();

        return view('games.round', ['game' => $game,
            'round' => $round,
            'categories' => $categories]);
    }

    public function storeCategory(Game $game, Round $round)
    {
        //validate the selected category
        $category_id = request()->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id']
        ])['category_id'];

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

        //flip the turns.
        $game->current_turn = $game->player_one_id === $game->current_turn
            ? $game->player_two_id
            : $game->player_one_id;
        $game->save();

        return redirect("/game/$game->id/round/$round->id/question/1");

    }

    public function showQuestion(Game $game, Round $round, int $order)
    {
        $roundQuestions = $round->roundQuestions()->where('order', $order)->firstOrFail();

        $question = $roundQuestions->question;

        $questionOptions = $question->questionOptions()->get();

        return view('games.question',
            compact('question', 'order', 'questionOptions'));
    }

    public function storeQuestion(Game $game, Round $round, int $order)
    {
        $roundAnswer = request()->validate([
            'selected_option_id' => ['required', 'integer', 'exists:question_options,id']
        ]);

    }





}
