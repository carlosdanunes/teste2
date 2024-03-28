<?php

namespace App\Http\Controllers\Admin\Affiliates;

use App\Http\Controllers\Controller;
use App\Jobs\Utils\ReprocessAllTransactionsByUserJob;
use App\Models\Affiliate;
use Illuminate\Http\Request;

class ReprocessTransactionsByAffiliateController extends Controller
{
    public function __invoke(Request $request, Affiliate $affiliate)
    {
        if ($affiliate) {
//            ReprocessAllTransactionsByUserJob::dispatch($affiliate);
        }

        return 'ok';
    }
}
