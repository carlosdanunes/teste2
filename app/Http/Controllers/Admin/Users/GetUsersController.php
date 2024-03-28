<?php

namespace App\Http\Controllers\Admin\Users;

use App\Filters\FilterUserGeneric;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\User\UsersResource;
use App\Models\User;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetUsersController extends Controller
{
    public function __invoke()
    {
        $transactions = QueryBuilder::for(User::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new FilterUserGeneric()),
            ])
            ->orderByDesc('created_at')
            ->paginate(15);

        return UsersResource::collection($transactions);
    }
}
