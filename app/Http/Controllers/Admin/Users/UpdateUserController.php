<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Http\Resources\Admin\User\UsersResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UpdateUserController extends Controller
{
    public function __invoke(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        $validated['ip'] = $request->ip();

        $user->update($validated);

        if(!empty($request->input('roles'))){
            DB::table('model_has_roles')->where('model_id',$user->id)->delete();
            $user->assignRole($request->input('roles'));
        }

        return response()->json([
            'message' => 'Atualizado com sucesso!',
            'user' => new UsersResource($user)
        ]);
    }
}
