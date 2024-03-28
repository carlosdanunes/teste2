<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Console\Command;

class ReprocessAllWalletsCommand extends Command
{
    protected $signature = 'reprocess:all-wallets';

    protected $description = 'Command description';

    public function handle(): void
    {
        $wallets = Wallet::all();

        foreach ($wallets as $wallet) {
            $this->info('Reprocessing wallet: ' . $wallet->id);

            $sumWithouCashout = Transaction::query()
                ->where('wallet_id', $wallet->id)
                ->where('name', "!=", 'cashout')
                ->where('status', 'approved')
                ->sum('amount');

            $sumCashoutDebit = Transaction::query()
                ->where('wallet_id', $wallet->id)
                ->where('name', 'cashout')
                ->whereIn('status', ['pending', 'approved'])
                ->sum('amount');

            $wallet->balance = $sumWithouCashout + $sumCashoutDebit;
            $wallet->save();
        }
    }
}
