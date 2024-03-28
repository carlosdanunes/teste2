<?php

namespace App\Http\Controllers\Admin\Affiliates;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Affiliate\AffiliatesResource;
use App\Models\Affiliate;

class GetAffiliateByIdController extends Controller
{
    public function __invoke(Affiliate $affiliate)
    {
        return response()->json(new AffiliatesResource($affiliate));
    }
}
