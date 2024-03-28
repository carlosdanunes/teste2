<?php

namespace App\Http\Controllers\Admin\Affiliates;

use App\Events\AffiliateRegisteredEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Affiliate\CreateAffiliateRequest;
use App\Http\Resources\Admin\Affiliate\AffiliatesResource;
use App\Models\Affiliate;

class CreateAffiliateController extends Controller
{
    public function __invoke(CreateAffiliateRequest $request)
    {
        $validated = $request->validated();
        $validated['ip'] = $request->ip();

        $affiliate = Affiliate::create($validated);

        if (!$affiliate) {
            return response()->json([
                'message' => 'Erro ao criar afiliado.'
            ], 500);
        }

        $affiliate->assignRole($request->input('roles'));

        return response()->json([
            'message' => 'Criado com sucesso!',
            'affiliate' => new AffiliatesResource($affiliate)
        ], 201);
    }
}
