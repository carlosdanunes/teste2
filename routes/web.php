<?php

use App\Http\Controllers\Api\Games\Integrations\BetSac\GetUsernameController;
use App\Http\Controllers\Api\Games\Integrations\Ezugi\EzugiController;
use App\Mail\User\PasswordResetMail;
use App\Models\Games\Crash;
use App\Models\GamesProvider;
use App\Services\Games\Integrations\GamesProviders\PgSoftService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $myip = Http::get('https://icanhazip.com');

    return response()->json([
        'message' => 'Welcome to the API PG ' . $myip,
    ]);
});


//Route::get('/ezugi/init-game', [EzugiController::class, 'createGame'])->name('ezugi.init-game');
// Route::get('/ezugi/init-game/{playerId}/{game_id}/{casino_id}', [EzugiController::class, 'createGame'])->name('ezugi.init-game'); // rota teste 

Route::get('/ezugi/init-game/{playerId}/{game_id}/{casino_id}', [EzugiController::class, 'createGame'])
    ->name('ezugi.init-game');

Route::post('/ezugi/rollback', [EzugiController::class, 'rollback'])
    ->name('ezugi.rollback');

Route::post('/ezugi/method', [EzugiController::class, 'method'])
    ->name('ezugi.method');

Route::post('/ezugi/get-balance', [EzugiController::class, 'getBalance'])
    ->name('ezugi.get-balance');

Route::post('/ezugi/debit', [EzugiController::class, 'debit'])
    ->name('ezugi.debit');

Route::post('/ezugi/credit', [EzugiController::class, 'credit'])
    ->name('ezugi.credit');Route::get('/ezugi/init-game/{playerId}/{game_id}/{casino_id}', [EzugiController::class, 'createGame'])
    ->name('ezugi.init-game');

Route::post('/ezugi/rollback', [EzugiController::class, 'rollback'])
    ->name('ezugi.rollback');

Route::post('/ezugi/method', [EzugiController::class, 'method'])
    ->name('ezugi.method');

Route::post('/ezugi/get-balance', [EzugiController::class, 'getBalance'])
    ->name('ezugi.get-balance');

Route::post('/ezugi/debit', [EzugiController::class, 'debit'])
    ->name('ezugi.debit');

Route::post('/ezugi/credit', [EzugiController::class, 'credit'])
    ->name('ezugi.credit');



Route::get("/client/initGame", GetUsernameController::class)->name("betsac.username");


Route::get('/loginn', function(){
    return response()->json([
        'message' => 'Welcome to the API PG ',
    ]);
});

Route::get('/health', function () {
    return response()->json([
        'message' => 'API is healthy',
    ]);
});

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

Route::get("/client/initGame", GetUsernameController::class)->name("betsac.username");

// Fivers gold_api [user_balance, transaction]
Route::post('/gold_api',  \App\Http\Controllers\Api\Games\Integrations\Fivers\GoldAPIController::class)->name('fivers-gold-api');