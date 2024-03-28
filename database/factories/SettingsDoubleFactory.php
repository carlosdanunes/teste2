<?php

namespace Database\Factories;

use App\Models\SettingsDouble;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SettingsDoubleFactory extends Factory
{
    protected $model = SettingsDouble::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
