<?php

namespace App\Http\Controllers\Admin\Affiliates;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Affiliate\ImpersonateAffiliateRequest;
use App\Models\Affiliate;

class ImpersonateAffiliateController extends Controller
{
    public function __invoke(ImpersonateAffiliateRequest $request)
    {
        $affiliate = Affiliate::find($request->affiliate_id);

        $token = $affiliate->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
