<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PGTokenValidationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $operatorToken = $request->input('operator_token');
        $secretKey = $request->input('secret_key');

        if ($operatorToken !== env('PG_OPERATOR_TOKEN') || $secretKey !== env('PG_SECRET_KEY')) {
            return response()->json([
                'data' => null,
                'error' => [
                    'code' => '1034',
                    'message' => 'Invalid request'
                ],
            ]);
        }

        return $next($request);
    }
}
