<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use App\Models\Role;

class GetRolesByIdController extends Controller
{
    public function __invoke(Role $role)
    {
        return response()->json($role);
    }
}
