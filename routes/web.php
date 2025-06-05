<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RoundController;
use App\Http\Controllers\SessionController;
use App\Http\Middleware\NoQuestionsIfAnswered;
use App\Http\Middleware\RedirectIfGameComplete;
use App\Http\Middleware\RedirectIfHasCategory;
use App\Http\Middleware\RedirectIfInGame;
use App\Http\Middleware\RedirectIfNoAnswers;
use App\Http\Middleware\RedirectIfRoundComplete;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterUserController;


Route::middleware('auth')->group(function () {

    Route::delete('/logout', action: [SessionController::class, 'destroy']);

    Route::get('/', [HomeController::class, 'index']);

    Route::get('/games', [GameController::class, 'index']);
    Route::get('/game/create', [GameController::class, 'create'])
        ->middleware(RedirectIfInGame::class);
    Route::post('/game', [GameController::class, 'store']);
    Route::get('/game/{game}', [GameController::class, 'show'])
        ->can('access', 'game');

    Route::get('/game/{game}/round/{round}', [RoundController::class, 'create'])
        ->middleware(RedirectIfHasCategory::class);
    Route::post('/game/{game}/round/{round}', [RoundController::class, 'store'])
        ->middleware(RedirectIfHasCategory::class);
    Route::get('/game/{game}/round/{round}/status', [RoundController::class, 'show'])
        ->middleware(RedirectIfNoAnswers::class);
    Route::post('/game/{game}/round/{round}/status', [RoundController::class, 'update'])
        ->middleware(RedirectIfRoundComplete::class);

    Route::get("/game/{game}/round/{round}/question",[QuestionController::class, 'show'])
        ->middleware([NoQuestionsIfAnswered::class, RedirectIfGameComplete::class]);
    Route::post('/game/{game}/round/{round}/question', [QuestionController::class, 'store']);

});


Route::middleware('guest')->group(function () {

    Route::view('/welcome', 'welcome')->name('login');
    Route::get('/register', [RegisterUserController::class, 'create']);
    Route::post('/register', [RegisterUserController::class, 'store']);
    Route::get('/login', [SessionController::class, 'create']);
    Route::post('/login', [SessionController::class, 'store']);

});



