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
    public function index()
    {

        $user = Auth::id();

        $games = Game::where(function ($query) {
            $query->where('player_one_id', Auth::id())
                ->orWhere('player_two_id', Auth::id());
        })->where('status', '!=', 'completed')->get();


        return view('games.index', compact('games'));
    }


    //adds the player to the queue
    public function queue()
    {

        MatchmakingQueue::create([
            'user_id' => Auth::user()->id,
        ]);

        return redirect('/games');

    }

    //shows the overall progress of a game
    //if it's the players turn, they're redirected to /game/{game}/round/{round} to choose a category.
    public function show(Game $game)
    {


        $rounds = Round::where('game_id', $game->id)->get();

        $userId = Auth::id();

        return view('games.show', compact('game', 'rounds', 'userId'));

    }


    public function update(Game $game, Round $round)
    {

        //update the round status
        if (RoundAnswer::where('round_id', $round->id)
                ->whereNotnull('selected_option_id')
                ->count() === 6) {
            $round->update([
                'status' => 1
            ]);
        }

        //create a new round
        if (RoundAnswer::where('round_id', $round->id)
                ->whereNotnull('selected_option_id')
                ->count() === 6 &&
            Round::where('game_id', $game->id)->count() < 4) {

            Round::updateOrcreate([
                'game_id' => $game->id,
                'round_number' => $round->round_number + 1
            ]);

        } elseif (RoundAnswer::where('round_id', $round->id)
                ->whereNotnull('selected_option_id')
                ->count() === 6 &&
            Round::where('game_id', $game->id)->count() === 4) {

            $roundIds = $game->rounds()->pluck('id');

            $answers = RoundAnswer::whereIn('round_id', $roundIds)
                ->whereNotNull('is_correct')
                ->get()
                ->groupBy('user_id')
                ->map(fn($group) => $group->where('is_correct', true)->count());

            $scores = $answers->all(); // [user_id => correct_count]
            arsort($scores);

            $ids = array_keys($scores);
            $values = array_values($scores);

            if ($values[0] === $values[1]) {

                $game->update([
                    'winner_id' => 0,
                    'status' => 'completed'
                ]);

            }

            $game->update([
                'winner_id' => $ids[0],
                'status' => 'completed'
            ]);

            $game->update([
                'status' => 'completed'
            ]);
        }

        return redirect("/game/$game->id/round/$round->id/question");
    }


}
