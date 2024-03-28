<?php

namespace App\Http\Controllers\Admin\Games\Providers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Games\Providers\GameProvidersResource;
use App\Models\GamesProvider;

class GetGameProviderByIdController extends Controller
{
    public function __invoke(GamesProvider $gamesProvider)
    {
        return response()->json(new GameProvidersResource($gamesProvider));
    }
}
