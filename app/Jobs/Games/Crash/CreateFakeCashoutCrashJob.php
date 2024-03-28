<?php

namespace App\Jobs\Games\Crash;

use App\Events\CashoutGameEvent;
use App\Models\Games\Crash;
use App\Models\Games\CrashBet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateFakeCashoutCrashJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        $this->onQueue('crash-cashout');
    }

    public function handle(): void
    {
        $randFakeBetLimit = rand(0, 3);

        $crash = Crash::query()
            ->latest()
            ->first();

        $bets = CrashBet::query()
            ->where('crash_id', $crash->id)
            ->where('fake', true)
            ->where('win', false)
            ->limit($randFakeBetLimit)
            ->inRandomOrder()
            ->get();

        if (!$crash || $bets->count() === 0) {
            return;
        }

        if ($crash->status === 'crashed') {
            return;
        }

        foreach ($bets as $bet) {
            $bet->update([
                'win' => true,
                'payout_multiplier' => $crash->multiplier,
            ]);

            CashoutGameEvent::dispatch($bet);
        }
    }
}
