<?php

namespace App\Http\Controllers\Admin;

use App\Filters\FilterBetweenDates;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\GetTransactionStatisticsResource;
use App\Models\Transaction;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetTransactionStatisticsController extends Controller
{
    public function __invoke()
    {
        $transactions = QueryBuilder::for(Transaction::class)
            ->allowedFilters([
                AllowedFilter::custom('created_at', new FilterBetweenDates()),
                AllowedFilter::exact('name'),
            ])
            ->orderByDesc('created_at')
            ->get();

        return GetTransactionStatisticsResource::collection($transactions);
    }
}
