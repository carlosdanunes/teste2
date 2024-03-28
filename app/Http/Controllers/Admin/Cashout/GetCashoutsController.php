<?php

namespace App\Http\Controllers\Admin\Cashout;

use App\Filters\FilterBetweenDates;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Cashout\GetCashoutsResource;
use App\Models\Payment\Cashout;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetCashoutsController extends Controller
{
    public function __invoke()
    {
        $deposits = QueryBuilder::for(Cashout::class)
            ->with('user')
            ->allowedFilters([
                AllowedFilter::custom('created_at', new FilterBetweenDates()),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('external_id'),
            ])
            ->orderByDesc('created_at')
            ->paginate();

        return GetCashoutsResource::collection($deposits);
    }
}
