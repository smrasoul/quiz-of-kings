<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\RoundController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterUserController;


Route::middleware('auth')->group(function () {

    Route::delete('/logout', action: [SessionController::class, 'destroy']);

    Route::get('/', [HomeController::class, 'index']);

    Route::get('/test', [QueueController::class, 'test']);

    Route::get('/games', [GameController::class, 'index']);
    Route::get('/game/create', [GameController::class, 'create']);
    Route::post('/game', [GameController::class, 'store']);
    Route::get('/game/{game}', [GameController::class, 'show'])
        ->can('access', 'game');

    Route::get('/game/{game}/round/{round}', [RoundController::class, 'create']);
    Route::post('/game/{game}/round/{round}', [RoundController::class, 'store']);
    Route::get('/game/{game}/round/{round}/status', [RoundController::class, 'show']);
    Route::post('/game/{game}/round/{round}/status', [RoundController::class, 'update']);

    Route::get("/game/{game}/round/{round}/question",[QuestionController::class, 'show']);
    Route::post('/game/{game}/round/{round}/question', [QuestionController::class, 'store']);

});


Route::middleware('guest')->group(function () {

    Route::view('/welcome', 'welcome')->name('login');
    Route::get('/register', [RegisterUserController::class, 'create']);
    Route::post('/register', [RegisterUserController::class, 'store']);
    Route::get('/login', [SessionController::class, 'create']);
    Route::post('/login', [SessionController::class, 'store']);

});



