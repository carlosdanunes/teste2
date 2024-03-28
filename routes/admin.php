<?php

use App\Http\Controllers\Admin\Cashout\ApproveCashoutController;
use App\Http\Controllers\Admin\Cashout\GetCashoutsController;
use App\Http\Controllers\Admin\Cashout\GetGatewayCashoutStatusController;
use App\Http\Controllers\Admin\Cashout\ReproveCashoutController;
use App\Http\Controllers\Admin\Configs\Games\Crash\GetSettingsController as GetCrashSettingsController;
use App\Http\Controllers\Admin\Configs\Games\Crash\UpdateSettingsController as UpdateCrashSettingsController;
use App\Http\Controllers\Admin\Configs\Games\Double\GetSettingsController as GetDoubleSettingsController;
use App\Http\Controllers\Admin\Configs\Games\Double\UpdateSettingsController as UpdateDoubleSettingsController;
use App\Http\Controllers\Admin\Configs\Gateways\CreateAvailableGatewayController;
use App\Http\Controllers\Admin\Configs\Gateways\CreateGatewayConfigController;
use App\Http\Controllers\Admin\Configs\Gateways\DeleteGatewayConfigController;
use App\Http\Controllers\Admin\Configs\Gateways\GetAvailableGatewaysController;
use App\Http\Controllers\Admin\Configs\Gateways\UpdateGatewayConfigController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Deposits\CancelDepositController;
use App\Http\Controllers\Admin\Deposits\CreateManualDepositController;
use App\Http\Controllers\Admin\Deposits\GetDepositsByIdController;
use App\Http\Controllers\Admin\Deposits\GetDepositsController;
use App\Http\Controllers\Admin\Deposits\ValidateDepositController;
use App\Http\Controllers\Admin\Games\Crash\ForceInitCrashController;
use App\Http\Controllers\Admin\Games\Providers\CreateAvailableGameProviderController;
use App\Http\Controllers\Admin\Games\Providers\DeleteGameProviderController;
use App\Http\Controllers\Admin\Games\Providers\GetGameProviderByIdController;
use App\Http\Controllers\Admin\Games\Providers\GetGameProvidersController;
use App\Http\Controllers\Admin\Games\Providers\GetGamesProviderListController;
use App\Http\Controllers\Admin\Games\Providers\UpdateGameProviderController;
use App\Http\Controllers\Admin\GetCashoutStatisticsController;
use App\Http\Controllers\Admin\GetTransactionStatisticsController;
use App\Http\Controllers\Admin\Permissions\FindPermissionController;
use App\Http\Controllers\Admin\Permissions\GetPermissionsController;
use App\Http\Controllers\Admin\Permissions\UpdatePermissionController;
use App\Http\Controllers\Admin\Reports\ChartStatisticsReportController;
use App\Http\Controllers\Admin\Reports\GamesStatisticsReportController;
use App\Http\Controllers\Admin\Roles\CreateRolesController;
use App\Http\Controllers\Admin\Roles\DeleteRolesController;
use App\Http\Controllers\Admin\Roles\GetRolesByIdController;
use App\Http\Controllers\Admin\Roles\GetRolesController;

use App\Http\Controllers\Admin\Affiliates\CreateAffiliateController;
use App\Http\Controllers\Admin\Affiliates\DeleteAffiliateController;
use App\Http\Controllers\Admin\Affiliates\GetAffiliateByIdController;
use App\Http\Controllers\Admin\Affiliates\GetAffiliatesController;
use App\Http\Controllers\Admin\Affiliates\ImpersonateAffiliateController;
use App\Http\Controllers\Admin\Affiliates\ReprocessTransactionsByAffiliateController;
use App\Http\Controllers\Admin\Affiliates\UpdateAffiliateController;

use App\Http\Controllers\Admin\Users\CreateUserController;
use App\Http\Controllers\Admin\Users\DeleteUserController;
use App\Http\Controllers\Admin\Users\GetUserByIdController;
use App\Http\Controllers\Admin\Users\GetUsersController;
use App\Http\Controllers\Admin\Users\ImpersonateController;
use App\Http\Controllers\Admin\Users\ReprocessTransactionsByUserController;
use App\Http\Controllers\Admin\Users\UpdateUserController;
use App\Http\Controllers\Api\Account\ChangePasswordController;
use App\Http\Controllers\Api\Account\GetProfileController;
use App\Http\Controllers\Api\Account\UpdateProfileController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\MeController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
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

Route::as('admin.auth.')->group(function () {
    Route::post('login', LoginController::class)->name('login');
    Route::post('forgot-password', ForgotPasswordController::class)->name('forgot-password');
    Route::post('reset-password', ResetPasswordController::class)->name('reset-password');

    Route::group(['middleware' => ['role_or_permission:admin|view.admin']], function () {
        route::middleware('auth:sanctum')->group(function () {
            Route::get('me', MeController::class)->name('me');
            Route::post('logout', LogoutController::class)->name('logout');

            Route::prefix('account')->as('account.')->group(function () {
                Route::get('profile', GetProfileController::class)->name('profile');
                Route::put('profile', UpdateProfileController::class)->name('profile.update');
                Route::put('change-password', ChangePasswordController::class)->name('change-password');
            });

            Route::prefix('reports')->as('reports.')->group(function () {
                Route::prefix('games')->as('games.')->group(function () {
                    Route::get('statistics', GamesStatisticsReportController::class)->name('statistics');
                    Route::get('chart', ChartStatisticsReportController::class)->name('chart');
                });
            });

            Route::prefix('dashboard')->group(function () {
                Route::get('/', DashboardController::class)->name('index');
                Route::get('transactions-statistics', GetTransactionStatisticsController::class)->name('transactions-statistics');
                Route::get('cashout-statistics', GetCashoutStatisticsController::class)->name('cashout-statistics');
            });

            Route::prefix('affiliates')->group(function () {
                Route::get('/', [GetAffiliatesController::class, '__invoke'])->name('affiliates');
                Route::get('{affiliate}', GetAffiliateByIdController::class)->name('get-affiliate-by-id');
                Route::put('{affiliate}', UpdateAffiliateController::class)->name('update-affiliate');
                Route::post('/', CreateAffiliateController::class)->name('create-affiliate');
                Route::delete('{affiliate}', DeleteAffiliateController::class)->name('delete-affiliate');

                //Route::post('impersonate', ImpersonateAffiliateController::class)->name('impersonate');
            });


            Route::prefix('users')->group(function () {
                Route::get('/', GetUsersController::class)->name('users');
                Route::get('{user}', GetUserByIdController::class)->name('get-user-by-id');
                Route::put('{user}', UpdateUserController::class)->name('update-user');
                Route::post('/', CreateUserController::class)->name('create-user');
                Route::delete('{user}', DeleteUserController::class)->name('delete-user');

                Route::post('impersonate', ImpersonateController::class)->name('impersonate');
            });

            Route::prefix('roles')->group(function () {
                Route::get('/', GetRolesController::class)->name('roles');
                Route::get('{role}', GetRolesByIdController::class)->name('get-role-by-id');
                Route::put('{role}', UpdateUserController::class)->name('update-role');
                Route::post('/', CreateRolesController::class)->name('create-role');
                Route::delete('{role}', DeleteRolesController::class)->name('delete-role');
            });

            Route::prefix('permissions')->group(function () {
                Route::get('/', GetPermissionsController::class)->name('permissions');
                Route::get('{permission}', FindPermissionController::class)->name('get-permission-by-id');
                Route::put('{permission}', UpdatePermissionController::class)->name('update-permission');
            });

            Route::prefix('deposits')->group(function () {
                Route::get('/', GetDepositsController::class)->name('deposit');
                Route::get('{deposit}', GetDepositsByIdController::class)->name('get-deposit-by-id');
                Route::put('{deposit}/cancel', CancelDepositController::class)->name('cancel-deposit');
                Route::put('{deposit}/validate', ValidateDepositController::class)->name('validate-deposit');
                Route::post('create-manual', CreateManualDepositController::class)->name('create-manual-deposit');
            });

            Route::prefix('cashouts')->group(function () {
                Route::get('/', GetCashoutsController::class)->name('cashout');
                Route::put('{cashout}/approve', ApproveCashoutController::class)->name('approve-cashout');
                Route::put('{cashout}/reprove', ReproveCashoutController::class)->name('cancel-cashout');
                Route::put('{cashout}/validate', GetGatewayCashoutStatusController::class)->name('get-cashout-status');
            });

            Route::prefix('configs')->group(function () {
                Route::prefix('gateways')->group(function () {
                    Route::get('/', GetAvailableGatewaysController::class)->name('get-available-gateways');
                    Route::post('/', CreateAvailableGatewayController::class)->name('create-available-gateway')->middleware(['role_or_permission:super-admin']);
                    Route::post('/config', CreateGatewayConfigController::class)->name('create-gateway-config');
                    Route::put('/config/{settingsGateway}', UpdateGatewayConfigController::class)->name('update-gateway-config');
                    Route::delete('/config/{settingsGateway}', DeleteGatewayConfigController::class)->name('delete-gateway-config');
                });
            });

            Route::prefix('games')->as('games.')->group(function () {
                Route::prefix('providers')->as('providers.')->group(function () {
                    Route::get('/', GetGameProvidersController::class)->name('get-game-providers');
                    Route::get('/{gamesProvider}', GetGameProviderByIdController::class)->name('get-game-provider-by-id');
                    Route::post('/', CreateAvailableGameProviderController::class)->name('create-available-game-provider');
                    Route::put('/{gamesProvider}', UpdateGameProviderController::class)->name('update-game-provider');
                    Route::delete('/{gamesProvider}', DeleteGameProviderController::class)->name('delete-game-provider');

                    Route::get('/{gamesProvider}/games-available', GetGamesProviderListController::class)->name('get-games');
                });
            });


            Route::prefix('settings')->group(function () {
                Route::prefix('crash')->group(function () {
                    Route::get('/', GetCrashSettingsController::class)->name('get-crash-settings');
                    Route::put('/', UpdateCrashSettingsController::class)->name('update-crash-settings');
                });
                Route::prefix('double')->group(function () {
                    Route::get('/', GetDoubleSettingsController::class)->name('get-double-settings');
                    Route::put('/', UpdateDoubleSettingsController::class)->name('update-double-settings');
                });
            });
        });
    });

    Route::get('/reprocess-transactions/{user}', ReprocessTransactionsByUserController::class)->name('reprocess-transactions-by-user');
});
