<?php

namespace App\Http\Middleware;

use App\Enums\Status;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfGameComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $game = $request->route('game');

        if($game->status === Status::COMPLETED){
            return redirect("/");
        }
        return $next($request);
    }
}
