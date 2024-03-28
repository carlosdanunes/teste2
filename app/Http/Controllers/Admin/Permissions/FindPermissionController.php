<?php

namespace App\Http\Controllers\Admin\Permissions;

use App\Http\Controllers\Controller;
use App\Models\Permission;

class FindPermissionController extends Controller
{
    public function __invoke(Permission $permission)
    {
        return response()->json($permission);
    }
}
