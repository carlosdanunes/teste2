<?php

namespace App\Http\Controllers\Admin\Configs\Games\Double;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Configs\Games\Double\UpdateDoubleRequest;
use App\Models\SettingsDouble;

class UpdateSettingsController extends Controller
{
    public function __invoke(UpdateDoubleRequest $request)
    {
        $validated = $request->validated();

        SettingsDouble::first()->update($validated);

        return response()->json([
            'message' => 'Configurações do Double atualizadas com sucesso!',
        ]);
    }
}
