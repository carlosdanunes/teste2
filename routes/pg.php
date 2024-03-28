<?php

use App\Http\Controllers\Api\Games\Integrations\PgSoft\Cash\AdjustmentController;
use App\Http\Controllers\Api\Games\Integrations\PgSoft\Cash\GetController;
use App\Http\Controllers\Api\Games\Integrations\PgSoft\Cash\TransferInController;
use App\Http\Controllers\Api\Games\Integrations\PgSoft\Cash\TransferInOutController;
use App\Http\Controllers\Api\Games\Integrations\PgSoft\Cash\TransferOutController;
use App\Http\Controllers\Api\Games\Integrations\PgSoft\VerifySessionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::as('pg.')->group(function () {
    Route::group(['middleware' => ['pgsoft']], function () {

        Route::post('VerifySession', VerifySessionController::class)->name('verify-session');

        Route::prefix('Cash')->group(function () {
            Route::post('Get', GetController::class)->name('cash.get');
            Route::post('TransferInOut', TransferInOutController::class)->name('cash.transfer-in-out');
            Route::post('Adjustment', AdjustmentController::class)->name('cash.adjustment');
        });
    });
});
