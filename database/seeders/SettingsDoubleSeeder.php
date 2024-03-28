<?php

namespace Database\Seeders;

use App\Models\SettingsDouble;
use Illuminate\Database\Seeder;

class SettingsDoubleSeeder extends Seeder
{
    public function run(): void
    {
        SettingsDouble::create([
            'fake_bets' => true,
            'fake_bets_min' => 20,
            'fake_bets_max' => 100,
            'next_double_value' => null,
            'next_double_color' => null,
            'percent_profit_daily' => 30,
            'percent_profit_week' => 30,
            'percent_profit_month' => 30,
            'double_timer' => 15,
        ]);
    }
}
