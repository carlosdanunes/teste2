<?php

namespace App\Http\Controllers\Admin\Users;

use App\Events\UserRegisteredEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\CreateUserRequest;
use App\Http\Resources\Admin\User\UsersResource;
use App\Models\User;

class CreateUserController extends Controller
{
    public function __invoke(CreateUserRequest $request)
    {
        $validated = $request->validated();
        $validated['ip'] = $request->ip();

        $user = User::create($validated);

        if(!$user){
            return response()->json([
                'message' => 'Erro ao criar usuário.'
            ], 500);
        }

        $user->assignRole($request->input('roles'));

        return response()->json([
            'message' => 'Criado com sucesso!',
            'user' => new UsersResource($user)
        ], 201);
    }
}
