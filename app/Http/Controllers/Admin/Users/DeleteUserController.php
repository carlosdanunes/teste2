<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\User;

class DeleteUserController extends Controller
{
    public function __invoke(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'Removido com sucesso!']);
    }
}
