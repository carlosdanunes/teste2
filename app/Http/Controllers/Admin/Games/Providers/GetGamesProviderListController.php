<?php

namespace App\Http\Controllers\Admin\Games\Providers;

use App\Http\Controllers\Controller;
use App\Models\GamesProvider;
use App\Services\Games\Integrations\GamesProviders\PgSoftService;

class GetGamesProviderListController extends Controller
{
    public function __invoke(GamesProvider $gamesProvider)
    {
        $service = new PgSoftService();

        return response()->json([
            $service->getGameList(),
        ]);
    }
}
