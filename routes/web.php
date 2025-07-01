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
use App\Models\RoundAnswer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterUserController;

Route::get('/test', function(){

    // Finalize the game
    $scores = RoundAnswer::where('game_id', 1)
        ->whereNotNull('is_correct')
        ->get()
        ->groupBy('user_id')
        ->map(fn($answers) => $answers->where('is_correct', true)->count())
        ->all();

    arsort($scores);
    $ids = array_keys($scores);
    $values = array_values($scores);

    $winnerId = $values[0] === $values[1] ? 0 : $ids[0];

    dump($winnerId);

});

Route::middleware('auth')->group(function () {

    Route::delete('/logout', action: [SessionController::class, 'destroy']);
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/games', [GameController::class, 'index']);


    Route::prefix('game')->group(function () {
        Route::get('/create', [GameController::class, 'create'])
            ->middleware(RedirectIfInGame::class);
        Route::post('/', [GameController::class, 'store']);
        Route::get('/{game}', [GameController::class, 'show'])
            ->can('access', 'game');
    });

    Route::prefix('game')->group(function () {
        Route::prefix('{game}/round/{round}')->group(function () {
            Route::middleware(RedirectIfHasCategory::class)->group(function () {
                Route::get('/', [RoundController::class, 'create']);
                Route::post('/', [RoundController::class, 'store']);
            });
            Route::get('/status', [RoundController::class, 'show'])
                ->middleware(RedirectIfNoAnswers::class);
            Route::post('/status', [RoundController::class, 'update'])
                ->middleware(RedirectIfRoundComplete::class);
            Route::get('/question', [QuestionController::class, 'show'])
                ->middleware([NoQuestionsIfAnswered::class, RedirectIfGameComplete::class]);
            Route::post('/question', [QuestionController::class, 'store']);
        });
    });



});


Route::middleware('guest')->group(function () {

    Route::view('/welcome', 'welcome')->name('login');
    Route::get('/register', [RegisterUserController::class, 'create']);
    Route::post('/register', [RegisterUserController::class, 'store']);
    Route::get('/login', [SessionController::class, 'create']);
    Route::post('/login', [SessionController::class, 'store']);

});



