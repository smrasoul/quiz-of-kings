<?php

namespace App\Http\Middleware;

use App\Models\RoundAnswer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NoQuestionsIfAnswered
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

        $answersCount = RoundAnswer::where('round_id', $round->id)
            ->where('user_id', Auth::id())
            ->whereNotNull('selected_option_id')
            ->count();

        if($answersCount > 2) {
            return redirect("/game/$game->id/round/$round->id/status");
        }
        return $next($request);
    }
}
