<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Category;
use App\Models\Game;
use App\Models\Question;
use App\Models\RandomCategories;
use App\Models\Round;
use App\Models\RoundAnswer;
use App\Models\RoundQuestion;
use Illuminate\Support\Facades\Auth;

class RoundController extends Controller
{
    public function create(Game $game, Round $round)
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
                ->where('game_id', $game->id)
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



        return view('games.category', compact('randomCategories'));
    }

    public function store(Game $game, Round $round)
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

    public function show (Game $game, Round $round)
    {
        $userId = Auth::id();

        $roundAnswers = RoundAnswer::where('user_id', $userId)
            ->where('round_id', $round->id)
            ->where('game_id', $game->id)
            ->with(['question', 'option'])
            ->get();

        if($roundAnswers->isEmpty()){
            return redirect("game/$game->id");
        }


        return view('games.status', compact('game','roundAnswers', 'round', 'userId'));
    }

    public function update(Game $game, Round $round)
    {
        if ($round->status === Status::COMPLETED) {
            return redirect("/game/$game->id");
        }

        //logic to flip the turn
        $currentRoundNumber = $round->round_number; // or whatever field stores this

        if (
            //if round is odd and turn is player1
            ($currentRoundNumber % 2 === 1 && $game->current_turn === $game->player_one_id) ||

            //if round is even and turn is player2
            ($currentRoundNumber % 2 === 0 && $game->current_turn === $game->player_two_id)

        ) {

            //flips the turn from 1 to 2 or from 2 to 1
            $game->current_turn = $game->player_one_id === $game->current_turn
                ? $game->player_two_id
                : $game->player_one_id;

            $game->save();
        }
        $completed = RoundAnswer::where('round_id', $round->id)
                ->where('game_id', $game->id)
                ->whereNotNull('selected_option_id')
                ->count();

        if ($completed === 6) {
            // Mark the round as completed
            $round->update(['status' => Status::COMPLETED]);

            $roundCount = Round::where('game_id', $game->id)->count();

            if ($roundCount < 4) {
                // Create the next round
                Round::updateOrCreate([
                    'game_id' => $game->id,
                    'round_number' => $round->round_number + 1,
                    'status' => Status::PENDING,
                ]);
            } elseif ($roundCount === 4) {

                // Finalize the game
                $scores = RoundAnswer::where('round_id', $round->id)
                    ->whereNotNull('is_correct')
                    ->get()
                    ->groupBy('user_id')
                    ->map(fn($answers) => $answers->where('is_correct', true)->count())
                    ->all();

                arsort($scores);
                $ids = array_keys($scores);
                $values = array_values($scores);

                $winnerId = $values[0] === $values[1] ? 0 : $ids[0];

                $game->update([
                    'winner_id' => $winnerId,
                    'status' => Status::COMPLETED
                ]);
            }
        }

        return redirect('/game/' . $game->id);

    }
}
