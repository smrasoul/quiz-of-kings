<?php

namespace App\Http\Middleware;

use App\Enums\Status;
use App\Models\RoundAnswer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfRoundComplete
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

        if ($round->status === Status::COMPLETED) {
            return redirect("/game/$game->id");
        }

        return $next($request);
    }
}
