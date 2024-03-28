<?php

namespace App\Jobs\Games\Crash;

use App\Models\Games\Crash;
use App\Models\Games\CrashBet;
use App\Models\SettingsCrash;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class CreateFakeBetCrashJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        $this->onQueue('crash-bet');
    }

    public function handle(): void
    {
        $settings = SettingsCrash::first();
        $randFakeBetLimit = rand($settings->fake_bets_min ?? 1, $settings->fake_bets_max ?? 100);

        $crash = Crash::query()
            ->latest()
            ->first();

        if (!$crash && $crash->status !== 'pending') {
            return;
        }

        $users = User::query()
            ->where('is_fake', true)
            ->limit($randFakeBetLimit)
            ->inRandomOrder()
            ->get();

        if (!$users->count()) {
            return;
        }

        foreach ($users as $user) {
            $bet = $this->generateValueBet();

            if ($bet > 0) {
                CrashBet::create([
                    'hash' => Str::uuid(),
                    'crash_id' => $crash->id,
                    'bet' => $this->generateValueBet(),
                    'balance_type' => 'wallet',
                    'user_id' => $user->id,
                    'win' => false,
                    'payout_multiplier' => 1,
                    'fake' => true,
                ]);
            }
        }
    }


    private function generateValueBet(): int
    {
        $rand = rand(0, 99);

        $decimal = [00, 00, 00, 00, 00, 00, 00, 00, 00, 00, 00, 00, 00, 20, 12, 00, 60, 35, 40, 00, 00, 80, 00, 70, 50];
        $cents = [50, 00, 00, 00, 00, 00, 00, 00, 00, 00, 00, 00, 00, 00, 00, 00, 00, 45, 75, 00, 95, 00, 5, 00, 25, 00, 15, 00, 35, 00, 65, 00, 85, 00];

        $thousand = match (true) {
            $rand <= 70 => rand(0, 9),
            $rand > 70 && $rand <= 95 => rand(10, 20),
            $rand > 95 => rand(20, 50),
        };

        $value = (int) $thousand . $decimal[rand(0, count($decimal) - 1)] . $cents[rand(0, count($cents) - 1)];

        if ($value == 0) {
            $value = rand(1, 100);
        }

        return $value;
    }
}
