<?php

namespace App\Http\Controllers\Admin\Deposits;

use App\Filters\FilterBetweenDates;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Deposits\GetDepositsResource;
use App\Models\Payment\Deposit;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetDepositsController extends Controller
{
    public function __invoke()
    {
        $deposits = QueryBuilder::for(Deposit::class)
            ->with('user', 'createdBy')
            ->allowedFilters([
                AllowedFilter::custom('created_at', new FilterBetweenDates()),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('external_id'),
            ])
            ->orderByDesc('created_at')
            ->paginate();

        return GetDepositsResource::collection($deposits);
    }
}
