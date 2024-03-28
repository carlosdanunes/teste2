<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use App\Models\Role;

class GetRolesController extends Controller
{
    public function __invoke()
    {
        return response()->json(Role::all());
    }
}
