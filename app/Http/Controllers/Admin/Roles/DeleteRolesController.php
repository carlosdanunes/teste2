<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use App\Models\Role;

class DeleteRolesController extends Controller
{
    public function __invoke(Role $role)
    {
        $role->delete();

        if(!$role){
            return response()->json([
                'message' => 'Erro ao deletar role.'
            ], 500);
        }

        return response()->json([
            'message' => 'Deletado com sucesso!',
            'role' => $role
        ], 200);
    }
}
