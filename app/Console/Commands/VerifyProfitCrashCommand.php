<?php

namespace App\Console\Commands;

use App\Models\Games\CrashBet;
use App\Models\SettingsCrash;
use App\Models\Transaction;
use Illuminate\Console\Command;

class VerifyProfitCrashCommand extends Command
{
    protected $signature = 'verify:profit-crash';

    protected $description = 'Command description';

    public function handle(): void
    {
        $this->info('Verify profit crash');

        $settings = SettingsCrash::first();

        $profitDaily = CrashBet::query()
            ->selectRaw('
                (sum(bet * payout_multiplier / 100) - sum(bet / 100)) * -1 as profit,
                sum(bet / 100) as bet,
                (
                    (sum(bet * payout_multiplier / 100) - sum(bet / 100))
                    / sum(bet / 100)
                ) * 100 as roi
            ')
            ->where('balance_type', 'wallet')
            ->where('fake', false)
            ->whereDate('created_at', now()->toDateString())
            ->first();

        $profitWeek = CrashBet::query()
            ->selectRaw('
                (sum(bet * payout_multiplier / 100) - sum(bet / 100)) * -1 as profit,
                sum(bet / 100) as bet,
                (
                    (sum(bet * payout_multiplier / 100) - sum(bet / 100))
                    / sum(bet / 100)
                ) * 100 as roi
            ')
            ->where('balance_type', 'wallet')
            ->where('fake', false)
            ->whereDate('created_at', '>=', now()->subDays(7)->toDateString())
            ->first();

        $profitMonth = CrashBet::query()
            ->selectRaw('
                (sum(bet * payout_multiplier / 100) - sum(bet / 100)) * -1 as profit,
                sum(bet / 100) as bet,
                (
                    (sum(bet * payout_multiplier / 100) - sum(bet / 100))
                    / sum(bet / 100)
                ) * 100 as roi
            ')
            ->where('balance_type', 'wallet')
            ->where('fake', false)
            ->whereDate('created_at', '>=', now()->subDays(30)->toDateString())
            ->first();

        if($settings->percent_profit_daily && $profitDaily->roi < $settings->percent_profit_daily) {
            $settings->next_crash_value = 1;
            $settings->save();
        }

        if($settings->percent_profit_week && $profitWeek->roi < $settings->percent_profit_week) {
            $settings->next_crash_value = 1;
            $settings->save();
        }

        if($settings->percent_profit_month && $profitMonth->roi < $settings->percent_profit_month) {
            $settings->next_crash_value = 1;
            $settings->save();
        }
    }
}
