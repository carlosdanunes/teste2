<?php

namespace App\Http\Controllers\Admin\Permissions;

use App\Http\Controllers\Controller;
use App\Models\Permission;

class GetPermissionsController extends Controller
{
    public function __invoke()
    {
        return response()->json(Permission::all());
    }
}
