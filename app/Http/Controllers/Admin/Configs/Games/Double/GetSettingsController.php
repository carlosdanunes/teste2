<?php

namespace App\Http\Controllers\Admin\Configs\Games\Double;

use App\Http\Controllers\Controller;
use App\Models\SettingsDouble;

class GetSettingsController extends Controller
{
    public function __invoke()
    {
        return SettingsDouble::first();
    }
}
