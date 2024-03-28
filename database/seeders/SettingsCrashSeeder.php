<?php

namespace Database\Seeders;

use App\Models\SettingsCrash;
use Illuminate\Database\Seeder;

class SettingsCrashSeeder extends Seeder
{
    public function run(): void
    {
        SettingsCrash::create([
            'fake_bets' => true,
            'fake_bets_min' =>  20,
            'fake_bets_max' => 100,
            'next_crash_value' => null,
            'percent_profit_daily' => 30,
            'percent_profit_week' => 30,
            'percent_profit_month' => 30,
            'crash_timer' => 10,
        ]);
    }
}
