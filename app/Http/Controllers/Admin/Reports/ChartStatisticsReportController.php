<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class ChartStatisticsReportController extends Controller
{
    public function __invoke()
    {
        $mines = Transaction::query()
            ->select(
                DB::raw('sum(amount)/-100 as y'),
                DB::raw('DATE(created_at) as x')
            )
            ->whereHas('user', function ($query) {
                $query->where('is_fake', false)
                    ->whereHas('roles', function ($query) {
                        $query->where('name', 'player');
                    });
            })
            ->where('status', 'approved')
            ->where('base_type', 'Mines')
            ->whereNotNull('wallet_id')
            ->where('created_at', '>=', now()->subDays(60)->startOfDay())
            ->groupBy('x')
            ->orderBy('x', 'asc')
            ->get();

        $double = Transaction::query()
            ->select(
                DB::raw('sum(amount)/-100 as y'),
                DB::raw('DATE(created_at) as x')
            )
            ->whereHas('user', function ($query) {
                $query->where('is_fake', false)
                    ->whereHas('roles', function ($query) {
                        $query->where('name', 'player');
                    });
            })
            ->where('status', 'approved')
            ->where('base_type', 'DoubleBet')
            ->whereNotNull('wallet_id')
            ->where('created_at', '>=', now()->subDays(60)->startOfDay())
            ->groupBy('x')
            ->orderBy('x', 'asc')
            ->get();

        $crash = Transaction::query()
            ->select(
                DB::raw('sum(amount)/-100 as y'),
                DB::raw('DATE(created_at) as x')
            )
            ->whereHas('user', function ($query) {
                $query->where('is_fake', false)
                    ->whereHas('roles', function ($query) {
                        $query->where('name', 'player');
                    });
            })
            ->where('status', 'approved')
            ->where('base_type', 'CrashBet')
            ->whereNotNull('wallet_id')
            ->where('created_at', '>=', now()->subDays(60)->startOfDay())
            ->groupBy('x')
            ->orderBy('x', 'asc')
            ->get();


        return [
            'mines' => $mines,
            'double' => $double,
            'crash' => $crash,
        ];
    }
}
