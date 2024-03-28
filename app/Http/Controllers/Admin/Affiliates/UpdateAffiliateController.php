<?php

namespace App\Http\Controllers\Admin\Affiliates;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Affiliate\UpdateAffiliateRequest;
use App\Http\Resources\Admin\Affiliate\AffiliatesResource;
use App\Models\Affiliate;
use Illuminate\Support\Facades\DB;

class UpdateAffiliateController extends Controller
{
    public function __invoke(UpdateAffiliateRequest $request, Affiliate $affiliate)
    {
        $validated = $request->validated();

        $validated['ip'] = $request->ip();

        $affiliate->update($validated);

        if (!empty($request->input('roles'))) {
            DB::table('model_has_roles')->where('model_id', $affiliate->id)->delete();
            $affiliate->assignRole($request->input('roles'));
        }

        return response()->json([
            'message' => 'Atualizado com sucesso!',
            'affiliate' => new AffiliatesResource($affiliate)
        ]);
    }
}
