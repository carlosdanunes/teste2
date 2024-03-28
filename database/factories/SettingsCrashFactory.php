<?php

namespace Database\Factories;

use App\Models\SettingsCrash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SettingsCrashFactory extends Factory
{
    protected $model = SettingsCrash::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
