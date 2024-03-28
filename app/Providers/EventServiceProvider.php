<?php

namespace App\Providers;

use App\Events\ApprovedDepositEvent;
use App\Events\CashoutGameEvent;
use App\Events\CreateBonusEvent;
use App\Events\CreateCashoutEvent;
use App\Events\CreateDepositEvent;
use App\Events\CreateBetGameEvent;
use App\Events\CreatePgGameEvent;
use App\Events\CreateTransactionEvent;
use App\Events\UpdateCashoutEvent;
use App\Events\UpdateDepositEvent;
use App\Events\UpdateRolloverEvent;
use App\Events\UserForgotPasswordEvent;
use App\Events\UserRegisteredEvent;
use App\Listeners\Bonus\CreateBonusMorphTransactionListener;
use App\Listeners\CheckRolloverListener;
use App\Listeners\CreateWalletUserListener;
use App\Listeners\Payment\AddCashoutInTransactionListener;
use App\Listeners\Payment\AddCpaValueBeforeDepositApprovedListener;
use App\Listeners\Payment\AddDepositBalanceIfHasBonusToBonusesListener;
use App\Listeners\Payment\AddDepositBalanceToWalletListener;
use App\Listeners\Payment\AddDepositInTransactionListener;
use App\Listeners\Payment\ChangeStatusCashoutInTransactionListener;
use App\Listeners\Payment\ChangeStatusDepositInTransactionListener;
use App\Listeners\Payment\RemoveBonusAfterCreateCashoutListener;
use App\Listeners\Payment\VerifyCashoutStatusToAddBalanceToWalletListener;
use App\Listeners\RemoveCashoutAmountInWalletListener;
use App\Listeners\SendApproveCashoutEmailListener;
use App\Listeners\SendApprovedDepositEmailListener;
use App\Listeners\SendBrokeAccountMailListener;
use App\Listeners\SendCreateCashoutEmailListener;
use App\Listeners\SendForgotEmailListener;
use App\Listeners\SendPlayGameEmailListener;
use App\Listeners\SendWelcomeEmailListener;
use App\Listeners\Transaction\CheckTransactionAffiliatesListener;
use App\Listeners\Transaction\CreateGameTransactionsAndAddBalanceListener;
use App\Listeners\Transaction\CreateGameTransactionsAndRemoveBalanceListener;
use App\Listeners\Transaction\CreatePgGameTransactionsAndFetchBalanceListener;
use App\Models\Bonus;
use App\Models\Games\Crash;
use App\Models\Games\CrashBet;
use App\Models\Games\Double;
use App\Models\Games\DoubleBet;
use App\Models\Games\Mines;
use App\Models\GamesBet;
use App\Models\Payment\Cashout;
use App\Models\Payment\Deposit;
use App\Models\Rollover;
use App\Models\SettingsGateway;
use App\Models\Transaction;
use App\Models\User;
use App\Observers\BonusObserver;
use App\Observers\CashoutObserver;
use App\Observers\DepositObserver;
use App\Observers\Game\CrashBetObserver;
use App\Observers\Game\CrashObserver;
use App\Observers\Game\DoubleBetObserver;
use App\Observers\Game\DoubleObserver;
use App\Observers\Game\MinesObserver;
use App\Observers\GamesBetObserver;
use App\Observers\RolloverObserver;
use App\Observers\SettingsGatewayObserver;
use App\Observers\TransactionObserver;
use App\Observers\UserObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        User::class => [UserObserver::class],
        Deposit::class => [DepositObserver::class],
        Mines::class => [MinesObserver::class],
        Crash::class => [CrashObserver::class],
        CrashBet::class => [CrashBetObserver::class],
        Double::class => [DoubleObserver::class],
        DoubleBet::class => [DoubleBetObserver::class],
        Bonus::class => [BonusObserver::class],
        Rollover::class => [RolloverObserver::class],
        Transaction::class => [TransactionObserver::class],
        Cashout::class => [CashoutObserver::class],
        SettingsGateway::class => [SettingsGatewayObserver::class],
        GamesBet::class => [GamesBetObserver::class],
    ];


    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        UserRegisteredEvent::class => [
            CreateWalletUserListener::class,
            SendWelcomeEmailListener::class,
        ],
        UserForgotPasswordEvent::class => [
            SendForgotEmailListener::class,
        ],
        CreateDepositEvent::class => [
            AddDepositInTransactionListener::class
        ],
        CreateBonusEvent::class => [
            CreateBonusMorphTransactionListener::class,
        ],
        UpdateDepositEvent::class => [
            ChangeStatusDepositInTransactionListener::class,
        ],
        ApprovedDepositEvent::class => [
            AddDepositBalanceToWalletListener::class,
            AddDepositBalanceIfHasBonusToBonusesListener::class,
            AddCpaValueBeforeDepositApprovedListener::class,
            SendApprovedDepositEmailListener::class,
        ],
        CreateBetGameEvent::class => [
            CreateGameTransactionsAndRemoveBalanceListener::class,
        ],
        CashoutGameEvent::class => [
            CreateGameTransactionsAndAddBalanceListener::class,
        ],
        UpdateRolloverEvent::class => [
           CheckRolloverListener::class
        ],
        CreateTransactionEvent::class => [
            CheckTransactionAffiliatesListener::class
        ],
        CreateCashoutEvent::class => [
            AddCashoutInTransactionListener::class,
            RemoveCashoutAmountInWalletListener::class,
            RemoveBonusAfterCreateCashoutListener::class,
            SendCreateCashoutEmailListener::class,
        ],
        UpdateCashoutEvent::class => [
            VerifyCashoutStatusToAddBalanceToWalletListener::class,
            ChangeStatusCashoutInTransactionListener::class,
            SendApproveCashoutEmailListener::class,
        ],
        CreatePgGameEvent::class => [
            CreatePgGameTransactionsAndFetchBalanceListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
