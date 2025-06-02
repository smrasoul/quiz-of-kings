<?php

namespace App\Http\Controllers;


use App\Enums\Status;
use App\Models\Game;
use App\Models\GameQueue;
use App\Models\Round;
use App\Models\RoundAnswer;
use Illuminate\Support\Facades\Auth;


class GameController extends Controller
{

    public function index(){

        $userId = Auth::id();

        $completedGames = Game::with(['playerOne:id,name', 'playerTwo:id,name'])
            //Game::with(['playerOne', 'playerTwo'])
            ->where('status', '=', 'completed')
            ->where(function ($query) use ($userId) {
                $query->where('player_one_id', $userId)
                    ->orWhere('player_two_id', $userId);
            })
            ->orderBy('last_activity', 'desc') // Sorting by date (newest first)
            ->paginate(3);

        return view('games.index', compact('completedGames', 'userId'));

    }

    //shows the overall progress of a game
    //if it's the players turn, they're redirected to /game/{game}/round/{round} to choose a category.
    public function show(Game $game)
    {


        $rounds = Round::where('game_id', $game->id)
            ->with([
                'roundAnswers.question',  // Ensures questions are preloaded
                'roundAnswers.option', // Preload question options
//                'roundAnswers.user',  // Eager-load the user (instead of multiple queries)
                'category',  // Preload category to avoid separate queries
            ])
            ->get();

        $userId = Auth::id();

        return view('games.show', compact('game', 'rounds', 'userId'));

    }

    public function create(){

        $userId = Auth::id();

        $queue = GameQueue::where('user_id', $userId)
            ->latest()->get();

        return view('games.create', compact('queue'));
    }

    public function store()
    {
        $player = GameQueue::latest()->first();

        $userId = Auth::id();
        if($player){
            $game = Game::create([
                'player_one_id' => $userId,
                'player_two_id' => $player->user_id,
                'current_turn' => 1,
                'last_activity' => now()->timestamp,
                'status' => Status::PENDING
            ]);
            Round::create([
                'game_id' => $game->id,
                'round_number' => 1,
                'status' => Status::PENDING
            ]);

            $player->delete();

            return redirect("/game/$game->id");
        }else{
            GameQueue::create([
               'user_id' => $userId,
                'queued_at' => now()
            ]);

            return redirect("/game/create");
        }


    }



}
