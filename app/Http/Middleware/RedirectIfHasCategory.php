<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfHasCategory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $round = $request->route('round');
        $game = $request->route('game');

        if ($round && $round->category_id !== null) {
            return redirect("/game/{$game->id}/round/{$round->id}/question");
        }

        return $next($request);
    }
}
