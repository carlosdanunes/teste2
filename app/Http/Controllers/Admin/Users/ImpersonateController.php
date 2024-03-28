<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\ImpersonateRequest;
use App\Models\User;


class ImpersonateController extends Controller
{
    public function __invoke(ImpersonateRequest $request)
    {
        $user = User::find($request->user_id);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
