<?php

namespace App\Http\Controllers\Admin\Configs\Games\Crash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Configs\Games\Crash\UpdateCrashRequest;
use App\Models\SettingsCrash;

class UpdateSettingsController extends Controller
{
    public function __invoke(UpdateCrashRequest $request)
    {
        $validated = $request->validated();

        $settings = SettingsCrash::first()->update($validated);

        return response()->json([
           'message' => 'Configurações do Crash atualizadas com sucesso!',
        ]);
    }
}
