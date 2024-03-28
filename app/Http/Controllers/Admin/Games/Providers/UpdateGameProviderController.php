<?php

namespace App\Http\Controllers\Admin\Games\Providers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Games\Providers\UpdateGameProviderRequest;
use App\Http\Resources\Admin\Games\Providers\GameProvidersResource;
use App\Models\GamesProvider;

class UpdateGameProviderController extends Controller
{
    public function __invoke(GamesProvider $gamesProvider, UpdateGameProviderRequest $request)
    {
        $gamesProvider->update($request->validated());

        return response()->json([
            'message' => 'GamesProvider atualizado com sucesso',
            'gamesProvider' => new GameProvidersResource($gamesProvider)
        ]);
    }
}
