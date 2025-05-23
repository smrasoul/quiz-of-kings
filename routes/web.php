<?php

use App\Http\Controllers\MatchmakingController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterUserController;


Route::middleware('auth')->group(function () {

    Route::view('/home', 'home')->name('home');
    Route::delete('/logout', action: [SessionController::class, 'destroy']);

    Route::get('/play', [MatchmakingController::class, 'create']);
    Route::post('/play', [MatchmakingController::class, 'store']);

    Route::get('/play/{id}', [MatchmakingController::class, 'show']);
});


Route::middleware('guest')->group(function () {

    Route::view('/', 'welcome');
    Route::get('/register', [RegisterUserController::class, 'create']);
    Route::post('/register', [RegisterUserController::class, 'store']);
    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);

});



