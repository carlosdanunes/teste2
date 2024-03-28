<?php

namespace Database\Seeders;

use App\Models\SettingsGateway;
use Illuminate\Database\Seeder;

class SettingsGatewaySeeder extends Seeder
{
    public function run(): void
    {
        SettingsGateway::updateOrCreate([
            'gateway_id' => 1,
        ], [
            'is_active' => true,
            'credentials' => [
                "client_id" => "eyJpZCI6ImMzM2NiYmJmLTZjOWEtMTFlZS1iNTA3LTQyMDEwYTk2MDAwYyIsIm5hbWUiOiJaaW4ifQ==",
                "client_secret" => "8uWseVzHB7vtXfG2Og0JYC9ry5wPbhcFNAxS3piaModZ1IUTQmDnL6Eq4KRklj"
            ],
        ]);
    }
}
