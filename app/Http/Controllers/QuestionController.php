<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Round;
use App\Models\RoundAnswer;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function show(Game $game, Round $round)
    {


        $answersCount = RoundAnswer::where('round_id', $round->id)
            ->where('user_id', Auth::id())
            ->whereNotNull('selected_option_id')
            ->count();

        if($answersCount > 2) {
            return redirect("/game/$game->id/round/$round->id/status");
        }

        $question = $round->roundQuestions()
            ->where('order', $answersCount + 1)
            ->firstOrFail()
            ->question;

        $questionOptions = $question->questionOptions()->get();

        $latestAnswer = $round->roundAnswers()
            ->where('user_id', Auth::id())
            ->latest()
            ->first();

        if (!$latestAnswer || $latestAnswer->selected_option_id !== null) {
            $round->roundAnswers()->create([
                'question_id' => $question->id,
                'user_id' => Auth::id(),
            ]);
        }

        return view('games.question',
            compact('question', 'questionOptions'));
    }

    public function store(Game $game, Round $round)
    {

        //validate the selected option
        $selectedOptionId = request()->validate([
            'selected_option_id' => ['required', 'integer', 'exists:question_options,id'],
        ])['selected_option_id'];


        $answersCount = RoundAnswer::where('round_id', $round->id)
            ->where('user_id', Auth::id())
            ->count();

        $question = $round->roundQuestions()
            ->where('order', $answersCount)
            ->firstOrFail()
            ->question;

        $isCorrect = $question->questionOptions
            ->findOrFail($selectedOptionId)
            ->is_correct;

        $roundAnswer = RoundAnswer::where('round_id', $round->id)
            ->where('question_id', $question->id)
            ->where('user_id', Auth::id())
            ->latest()
            ->firstOrFail();

        if($roundAnswer->selected_option_id === null){
            $roundAnswer->update([
                'selected_option_id' => $selectedOptionId,
                'is_correct' => $isCorrect,
            ]);
        }

        return redirect("/game/$game->id/round/$round->id/question");

    }
}
