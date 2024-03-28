<?php

namespace App\Jobs\Games\Double;


use App\Models\Games\Double;
use App\Models\Games\DoubleBet;
use App\Models\SettingsDouble;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class CreateFakeBetDoubleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        $this->onQueue('double-bet');
    }

    public function handle(): void
    {
        $settings = SettingsDouble::first();
        $randFakeBetLimit = rand($settings->fake_bets_min ?? 1, $settings->fake_bets_max ?? 100);

        $double = Double::query()
            ->orderByRaw('FIELD(status, "pending") DESC')
            ->latest()
            ->first();

        if (!$double) {
            return;
        }

        $users = User::query()
            ->where('is_fake', true)
            ->limit($randFakeBetLimit)
            ->inRandomOrder()
            ->get();

        if (!$users) {
            return;
        }

        foreach ($users as $user) {
            $bet = $this->generateValueBet();

            if ($bet > 0) {
                DoubleBet::create([
                    'hash' => Str::uuid(),
                    'double_id' => $double->id,
                    'bet' => $this->generateValueBet(),
                    'balance_type' => 'wallet',
                    'bet_color' => $this->generateColorToBet(),
                    'user_id' => $user->id,
                    'payout_multiplier' => 0,
                    'win' => false,
                    'fake' => true,
                ]);
            }
        }
    }

    private function generateColorToBet(): string
    {
        $rand = rand(1, 3);

        $color = match (true) {
            $rand === 1 => 'white',
            $rand === 2 => 'green',
            $rand === 3 => 'black',
        };

        return $color;
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
