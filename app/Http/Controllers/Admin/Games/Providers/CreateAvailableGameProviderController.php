<?php

namespace App\Http\Controllers\Admin\Games\Providers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Games\Providers\CreateAvailableGamesProviderRequest;
use App\Http\Resources\Admin\Games\Providers\GameProvidersResource;
use App\Models\GamesProvider;

class CreateAvailableGameProviderController extends Controller
{
    public function __invoke(CreateAvailableGamesProviderRequest $request)
    {
        $gamesProvider = GamesProvider::create($request->validated());

        return response()->json([
            'message' => 'GamesProvider criado com sucesso',
            'gamesProvider' => new GameProvidersResource($gamesProvider)
        ]);
    }
}
