<?php

namespace App\Http\Controllers\Admin;

use App\Filters\FilterBetweenDates;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\GetCashoutStatisticsResource;
use App\Models\Payment\Cashout;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetCashoutStatisticsController extends Controller
{
    public function __invoke()
    {
        $transactions = QueryBuilder::for(Cashout::class)
            ->allowedFilters([
                AllowedFilter::custom('created_at', new FilterBetweenDates()),
                AllowedFilter::exact('status'),
            ])
            ->orderByDesc('created_at')
            ->get();

        return GetCashoutStatisticsResource::collection($transactions);
    }
}
