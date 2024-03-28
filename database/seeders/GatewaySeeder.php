<?php

namespace Database\Seeders;

use App\Models\Gateway;
use App\Models\SettingsGateway;
use Illuminate\Database\Seeder;


class GatewaySeeder extends Seeder
{
    public function run(): void
    {
        Gateway::updateOrCreate([
            'name' => 'Ezzebank',
            'slug' => 'ezzebank',
        ], [
            'fields' => [
                "client_id",
                "client_secret"
            ],
        ]);

        Gateway::updateOrCreate([
            'name' => 'SuitPay',
            'slug' => 'suitpay',
        ], [
            'fields' => [
                "client_id",
                "client_secret"
            ],
        ]);

        Gateway::updateOrCreate([
            'name' => 'Manual',
            'slug' => 'manual',
        ], [
            'fields' => [],
        ]);


        SettingsGateway::create([
            'is_active' => false,
            'credentials' => null,
            'gateway_id' => Gateway::where('slug', 'manual')->first()->id,
        ]);
    }
}
