<?php

namespace App\Http\Controllers\Admin\Affiliates;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;

class DeleteAffiliateController extends Controller
{
    public function __invoke(Affiliate $affiliate)
    {
        $affiliate->delete();

        return response()->json(['message' => 'Removido com sucesso!']);
    }
}
