<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Roles\CreateRoleRequest;
use App\Models\Role;

class CreateRolesController extends Controller
{
    public function __invoke(CreateRoleRequest $request)
    {
        $validated = $request->validated();

        $role = Role::create([
            'name' => $validated['name'],
            'title' => $validated['title'],
            'guard_name' => $validated['guard_name']
        ]);

        $permissions = $request->input('permissions');

        $role->syncPermissions($permissions);

        if(!$role){
            return response()->json([
                'message' => 'Erro ao criar role.'
            ], 500);
        }

        return response()->json([
            'message' => 'Criado com sucesso!',
            'role' => $role
        ], 201);
    }
}
