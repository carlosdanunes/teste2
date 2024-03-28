<?php

namespace App\Http\Controllers\Admin\Configs\Games\Crash;

use App\Http\Controllers\Controller;
use App\Models\SettingsCrash;

class GetSettingsController extends Controller
{
    public function __invoke()
    {
        return SettingsCrash::first();
    }
}
