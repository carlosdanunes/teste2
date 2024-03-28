<?php

namespace App\Http\Controllers\Admin\Affiliates;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;

class GetAffiliatesController extends Controller
{
    public function __invoke()
    {
        $affiliates = User::query()
            ->role('affiliate')
            ->orderByDesc('created_at')
            ->paginate(15);

        $affiliatesWithStats = $affiliates->map(function ($affiliate) {
            $affiliateStats = $this->getAffiliateStatistics($affiliate);

            return [
                'id' => $affiliate->id,
                'name' => $affiliate->name,
                'email' => $affiliate->email,
                'username' => $affiliate->username,
                'document' => $affiliate->document,
                'phone' => $affiliate->phone,
                'avatar' => $affiliate->avatar,
                'ip' => $affiliate->ip,
                'email_verified_at' => $affiliate->email_verified_at,
                'last_login_at' => $affiliate->last_login_at,
                'birth_date' => $affiliate->birth_date,
                'pix_key' => $affiliate->pix_key,
                'pix_key_type' => $affiliate->pix_key_type,
                'ref_code' => $affiliate->ref_code,
                'affiliate_percent_revenue_share' => $affiliate->affiliate_percent_revenue_share,
                'affiliate_percent_revenue_share_sub' => $affiliate->affiliate_percent_revenue_share_sub,
                'affiliate_cpa' => $affiliate->affiliate_cpa,
                'affiliate_cpa_sub' => $affiliate->affiliate_cpa_sub,
                'affiliate_min_deposit_cpa' => $affiliate->affiliate_min_deposit_cpa,
                'fake_affiliate_percent_revenue_share' => $affiliate->fake_affiliate_percent_revenue_share,
                'fake_affiliate_percent_revenue_share_sub' => $affiliate->fake_affiliate_percent_revenue_share_sub,
                'fake_affiliate_cpa' => $affiliate->fake_affiliate_cpa,
                'fake_affiliate_cpa_sub' => $affiliate->fake_affiliate_cpa_sub,
                'fake_affiliate_min_deposit_cpa' => $affiliate->fake_affiliate_min_deposit_cpa,
                'affiliate_id' => $affiliate->affiliate_id,
                'roles' => $affiliate->getRoleNames(),
                'permissions' => $affiliate->getAllPermissions()->pluck('name'),
                'created_at' => $affiliate->created_at->format('d/m/Y H:i'),
                'statistics' => $affiliateStats,
            ];
        });

        return [
            'data' => $affiliatesWithStats,
            'links' => $affiliates->toArray()['links'],
            'meta' => [
                'current_page' => $affiliates->currentPage(),
                'from' => $affiliates->firstItem(),
                'last_page' => $affiliates->lastPage(),
                'links' => $affiliates->toArray()['links'],
                'path' => $affiliates->path(),
                'per_page' => $affiliates->perPage(),
                'to' => $affiliates->lastItem(),
                'total' => $affiliates->total(),
            ],
        ];
    }

    protected function getAffiliateStatistics($affiliate)
    {
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        $totalDeposits = $affiliate->affiliates()
            ->with('deposits')
            ->get()
            ->sum(function ($referencedAffiliate) use ($startOfWeek, $endOfWeek) {
                return $referencedAffiliate->deposits()
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->sum('amount');
            });

        $totalWithdrawals = $affiliate->referencedWithdrawalTransactions()
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('amount');

        $totalProfit = $totalDeposits - $totalWithdrawals;

        $totalAvailableForWithdrawal = $affiliate->affiliates()
            ->get()
            ->sum(function ($referencedAffiliate) {
                return $referencedAffiliate->fake_affiliate_cpa + $referencedAffiliate->fake_affiliate_percent_revenue_share;
            });

        return [
            'total_deposits_week' => (int) $totalDeposits,
            'total_withdrawals_week' => (int) $totalWithdrawals,
            'total_profit_week' => (int) $totalProfit,
            'total_available_for_withdrawal_week' => (int) $totalAvailableForWithdrawal,
        ];
    }
}
