<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //check if the player is already in a game or queue
    //player can post a form to be added to the queue (queue method)
    //or be redirected to /game/{game} (show method)
    //can view two last finished games and go to full history
    public function index()
    {
        $userId = Auth::id();

        $games = Game::with(['playerOne:id,name', 'playerTwo:id,name'])
            //Game::with(['playerOne', 'playerTwo'])
            ->where('status', '=', 'pending')
            ->where(function ($query) use ($userId) {
                $query->where('player_one_id', $userId)
                    ->orWhere('player_two_id', $userId);
            })
            ->latest() // Orders by created_at descending
            ->take(2)  // Limits to 2 results
            ->get();

        $completedGames = Game::with(['playerOne:id,name', 'playerTwo:id,name'])
            ->where('status', '=', 'completed')
            ->where(function ($query) use ($userId) {
                $query->where('player_one_id', $userId)
                    ->orWhere('player_two_id', $userId);
            })
            ->orderBy('last_activity', 'desc') // Sorting by date (newest first)
            ->take(2)  // Limits to 2 results
            ->get();

        return view('home', compact('games', 'completedGames', 'userId'));
    }
}
