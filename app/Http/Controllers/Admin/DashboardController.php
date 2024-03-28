<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\DashboardResource;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return response()->json(new DashboardResource($this));
    }
}
