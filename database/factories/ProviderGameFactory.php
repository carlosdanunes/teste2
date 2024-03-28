<?php

namespace Database\Factories;

use App\Models\ProviderGame;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProviderGameFactory extends Factory
{
    protected $model = ProviderGame::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
