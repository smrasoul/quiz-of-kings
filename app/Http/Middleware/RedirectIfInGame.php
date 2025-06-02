<?php

namespace App\Http\Middleware;

use App\Enums\Status;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Game;

class RedirectIfInGame
{
    public function handle($request, Closure $next)
    {
        $userId = Auth::id();

        $game = Game::where(function ($query) use ($userId) {
            $query->where('player_one_id', $userId)
                ->orWhere('player_two_id', $userId);
        })->where('status', Status::PENDING)->first();

        if ($game) {
            return redirect("/game/{$game->id}");
        }

        return $next($request);
    }
}

