<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterUserController;


Route::middleware('auth')->group(function () {

    Route::view('/home', 'home')->name('home');
    Route::delete('/logout', action: [SessionController::class, 'destroy']);

    Route::get('/games', [GameController::class, 'index']);
    Route::post('/games', [GameController::class, 'queue']);

    Route::get('/game/{game}', [GameController::class, 'show'])
    ->can('access', 'game');

    Route::get('/game/{game}/round/{round}', [GameController::class, 'selectCategory']);
    Route::post('/game/{game}/round/{round}', [GameController::class, 'storeCategory']);

    Route::get("/game/{game}/round/{round}/question/{order}",[GameController::class, 'showQuestion']);
    Route::post('/game/{game}/round/{round}/question/{order}', [GameController::class, 'storeQuestion']);
});


Route::middleware('guest')->group(function () {

    Route::view('/', 'welcome');
    Route::get('/register', [RegisterUserController::class, 'create']);
    Route::post('/register', [RegisterUserController::class, 'store']);
    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);

});



