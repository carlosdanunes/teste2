<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Roles\UpdateRolesRequest;
use App\Models\Role;

class UpdateRolesController extends Controller
{
    public function __invoke(UpdateRolesRequest $request, Role $role)
    {
        $validated = $request->validated();

        $role->update([
            'name' => $validated['name'],
            'title' => $validated['title'],
            'guard_name' => $validated['guard_name']
        ]);

        $permissions = $request->input('permissions');

        $role->syncPermissions($permissions);

        if(!$role){
            return response()->json([
                'message' => 'Erro ao atualizar role.'
            ], 500);
        }

        return response()->json([
            'message' => 'Atualizado com sucesso!',
            'role' => $role
        ], 200);
    }
}
