<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Jobs\Utils\ReprocessAllTransactionsByUserJob;
use App\Models\User;
use Illuminate\Http\Request;

class ReprocessTransactionsByUserController extends Controller
{
    public function __invoke(Request $request, User $user)
    {
        if($user){
//            ReprocessAllTransactionsByUserJob::dispatch($user);
        }

        return 'ok';
    }
}
