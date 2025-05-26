<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterUserController;


Route::middleware('auth')->group(function () {

    Route::delete('/logout', action: [SessionController::class, 'destroy']);

    Route::get('/', [GameController::class, 'index']);



    Route::get('/game/{game}', [GameController::class, 'show'])
    ->can('access', 'game');

    Route::get('/game/{game}/round/{round}', [GameController::class, 'createRoundQuestion']);

    Route::post('/game/{game}/round/{round}', [GameController::class, 'storeRoundQuestion']);

    Route::get("/game/{game}/round/{round}/question",[GameController::class, 'showQuestion']);
    Route::post('/game/{game}/round/{round}/question', [GameController::class, 'storeQuestion']);
});


Route::middleware('guest')->group(function () {

    Route::view('/welcome', 'welcome')->name('login');
    Route::get('/register', [RegisterUserController::class, 'create']);
    Route::post('/register', [RegisterUserController::class, 'store']);
    Route::get('/login', [SessionController::class, 'create']);
    Route::post('/login', [SessionController::class, 'store']);

});



