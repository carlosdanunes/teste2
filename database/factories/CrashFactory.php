<?php

namespace Database\Factories;

use App\Models\Games\Crash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CrashFactory extends Factory
{
    protected $model = Crash::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
