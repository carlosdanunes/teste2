<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\User\UsersResource;
use App\Models\User;

class GetUserByIdController extends Controller
{
    public function __invoke(User $user)
    {
        return response()->json(new UsersResource($user));
    }
}
