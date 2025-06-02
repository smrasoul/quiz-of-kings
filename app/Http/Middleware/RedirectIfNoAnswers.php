<?php

namespace App\Http\Middleware;

use App\Models\RoundAnswer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNoAnswers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = Auth::id();
        $round = $request->route('round');
        $game = $request->route('game');

        $roundAnswers = RoundAnswer::where('user_id', $userId)
            ->where('round_id', $round->id)
            ->where('game_id', $game->id)
            ->whereNotNull('selected_option_id')
            ->with(['question', 'option'])
            ->get()
            ->count();

        if($roundAnswers < 3){
            return redirect("game/$game->id");
        }

        return $next($request);
    }
}
