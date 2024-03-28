<?php

namespace App\Http\Controllers\Admin\Games\Providers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Games\Providers\GameProvidersResource;
use App\Models\GamesProvider;
use Illuminate\Http\Request;

class GetGameProvidersController extends Controller
{
    public function __invoke(Request $request)
    {
        $gamesProviders = GamesProvider::all();

        return response()->json(GameProvidersResource::collection($gamesProviders));
    }
}
