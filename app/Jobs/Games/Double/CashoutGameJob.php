<?php

namespace App\Jobs\Games\Double;

use App\Enum\DoubleWinningMultiplier;
use App\Events\CashoutGameEvent;
use App\Models\Games\Double;
use App\Models\Games\DoubleBet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CashoutGameJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Double $double
    ) {
        $this->onQueue('double-cashout');
    }

    public function handle(): void
    {
        $double = $this->double;

        $bets = DoubleBet::query()
            ->where('double_id', $double->id)
            ->where('bet_color', $double->winning_color)
            ->where('fake', false)
            ->get();

        foreach ($bets as $bet) {
            $bet->update([
                'win' => true,
                'payout_multiplier' => DoubleWinningMultiplier::getMultiplier($double->winning_color)->value,
            ]);

            CashoutGameEvent::dispatch($bet);
        }
    }
}
