<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Game;
use App\Models\Question;
use App\Models\RandomCategories;
use App\Models\Round;
use App\Models\RoundQuestion;

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
}
