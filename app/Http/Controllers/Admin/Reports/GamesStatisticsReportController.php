<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class GamesStatisticsReportController extends Controller
{
    public function __invoke()
    {
        $transactions = new Transaction();

        $mines_today = $transactions->query()
            ->whereHas('user', function ($query) {
                $query->where('is_fake', false)
                    ->whereHas('roles', function ($query) {
                        $query->where('name', 'player');
                    });
            })
            ->where('status', 'approved')
            ->where('base_type', 'Mines')
            ->whereNotNull('wallet_id')
            ->whereDate('created_at', today())
            ->sum('amount');

        $mines_week = $transactions->query()
            ->whereHas('user', function ($query) {
                $query->where('is_fake', false)
                    ->whereHas('roles', function ($query) {
                        $query->where('name', 'player');
                    });
            })
            ->where('status', 'approved')
            ->where('base_type', 'Mines')
            ->whereNotNull('wallet_id')
            ->whereBetween('created_at', [today()->startOfWeek()->startOfDay(), today()->endOfWeek()->endOfDay()])
            ->sum('amount');

        $mines_month = $transactions->query()
            ->whereHas('user', function ($query) {
                $query->where('is_fake', false)
                    ->whereHas('roles', function ($query) {
                        $query->where('name', 'player');
                    });
            })
            ->where('status', 'approved')
            ->where('base_type', 'Mines')
            ->whereNotNull('wallet_id')
            ->whereBetween('created_at', [today()->startOfMonth()->startOfDay(), today()->endOfMonth()->endOfDay()])
            ->sum('amount');

        $double_today = $transactions->query()
            ->whereHas('user', function ($query) {
                $query->where('is_fake', false)
                    ->whereHas('roles', function ($query) {
                        $query->where('name', 'player');
                    });
            })
            ->where('status', 'approved')
            ->where('base_type', 'DoubleBet')
            ->whereNotNull('wallet_id')
            ->whereDate('created_at', today())
            ->sum('amount');

        $double_week = $transactions->query()
            ->whereHas('user', function ($query) {
                $query->where('is_fake', false)
                    ->whereHas('roles', function ($query) {
                        $query->where('name', 'player');
                    });
            })
            ->where('status', 'approved')
            ->where('base_type', 'DoubleBet')
            ->whereNotNull('wallet_id')
            ->whereBetween('created_at', [today()->startOfWeek()->startOfDay(), today()->endOfWeek()->endOfDay()])
            ->sum('amount');

        $double_month = $transactions->query()
            ->whereHas('user', function ($query) {
                $query->where('is_fake', false)
                    ->whereHas('roles', function ($query) {
                        $query->where('name', 'player');
                    });
            })
            ->where('status', 'approved')
            ->where('base_type', 'DoubleBet')
            ->whereNotNull('wallet_id')
            ->whereBetween('created_at', [today()->startOfMonth()->startOfDay(), today()->endOfMonth()->endOfDay()])
            ->sum('amount');

        $crash_today = $transactions->query()
            ->whereHas('user', function ($query) {
                $query->where('is_fake', false)
                    ->whereHas('roles', function ($query) {
                        $query->where('name', 'player');
                    });
            })
            ->where('status', 'approved')
            ->where('base_type', 'CrashBet')
            ->whereNotNull('wallet_id')
            ->whereDate('created_at', today())
            ->sum('amount');

        $crash_week = $transactions->query()
            ->whereHas('user', function ($query) {
                $query->where('is_fake', false)
                    ->whereHas('roles', function ($query) {
                        $query->where('name', 'player');
                    });
            })
            ->where('status', 'approved')
            ->where('base_type', 'CrashBet')
            ->whereNotNull('wallet_id')
            ->whereBetween('created_at', [today()->startOfWeek()->startOfDay(), today()->endOfWeek()->endOfDay()])
            ->sum('amount');

        $crash_month = $transactions->query()
            ->whereHas('user', function ($query) {
                $query->where('is_fake', false)
                    ->whereHas('roles', function ($query) {
                        $query->where('name', 'player');
                    });
            })
            ->where('status', 'approved')
            ->where('base_type', 'CrashBet')
            ->whereNotNull('wallet_id')
            ->whereBetween('created_at', [today()->startOfMonth()->startOfDay(), today()->endOfMonth()->endOfDay()])
            ->sum('amount');

        return [
            'mines' => [
                'today' => -$mines_today,
                'week' => -$mines_week,
                'month' => -$mines_month,
            ],
            'double' => [
                'today' => -$double_today,
                'week' => -$double_week,
                'month' => -$double_month,
            ],
            'crash' => [
                'today' => -$crash_today,
                'week' => -$crash_week,
                'month' => -$crash_month,
            ],
        ];
    }
}
