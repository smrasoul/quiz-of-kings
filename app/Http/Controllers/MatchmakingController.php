<?php

namespace App\Http\Controllers;

use App\Models\GameMatches;
use App\Models\MatchmakingQueue;
use Illuminate\Support\Facades\Auth;

class MatchmakingController extends Controller
{
    public function create(){



        $queued = MatchmakingQueue::where('user_id', Auth::user()->id )->first();
        $match = GameMatches::where(function ($query) {
            $query->where('player_one_id', Auth::id())
                ->orWhere('player_two_id', Auth::id());
        })->where('status', '!=', 'completed')->first();


        return view('matchmaking.create', ['queued' => $queued,
            'match' => $match]);
    }

    public function store(){

        MatchmakingQueue::create([
            'user_id' => Auth::user()->id,
        ]);

        return redirect('/play');

    }

    public function show(){

        $match = GameMatches::where(function ($query) {
            $query->where('player_one_id', Auth::id())
                ->orWhere('player_two_id', Auth::id());
        })->where('status', '!=', 'completed')->first();

        dd($match);
    }
}
