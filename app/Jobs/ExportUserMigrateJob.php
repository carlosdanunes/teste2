<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ExportUserMigrateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;

    /**
     * Create a new job instance.
     *
     * @param int $userId
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
        $this->onQueue('migrate');
    }

    public function handle(): void
    {
        $user = User::with(['wallet', 'wallet_revenue_share', 'wallet_cpa'])->findOrFail($this->userId);

        $response = Http::post('https://api.sistema.bet/api/migrate/81d74eb9-6b17-4f14-9a71-0b373340c519', [
            'user' => $user->toArray(),
            'balance_real' => $user->wallet->balance,
            'balance_rev' => $user->wallet_revenue_share->balance,
            'balance_cpa' => $user->wallet_cpa->balance,
        ]);

        if ($response->successful()) {
            $user->update(['migrated' => true]);
        }
    }

}
