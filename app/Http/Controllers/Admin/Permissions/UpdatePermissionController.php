<?php

namespace App\Http\Controllers\Admin\Permissions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Permissions\UpdatePermissionRequest;
use App\Models\Permission;

class UpdatePermissionController extends Controller
{
    public function __invoke(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update($request->validated());

        if(!$permission){
            return response()->json([
                'message' => 'Erro ao atualizar permissão.'
            ], 500);
        }

        return response()->json([
            'message' => 'Atualizado com sucesso!',
            'permission' => $permission
        ], 200);
    }
}
