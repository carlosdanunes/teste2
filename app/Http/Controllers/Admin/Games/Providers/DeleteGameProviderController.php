<?php

namespace App\Http\Controllers\Admin\Games\Providers;

use App\Http\Controllers\Controller;
use App\Models\GamesProvider;

class DeleteGameProviderController extends Controller
{
    public function __invoke(GamesProvider $gamesProvider)
    {
        $gamesProvider->delete();

        return response()->json([
            'message' => 'Provedor de jogo deletado com sucesso',
        ]);
    }
}
