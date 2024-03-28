<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class exportUserDescCommand extends Command
{
    protected $signature = 'export:userdesc';

    protected $description = 'Command description';

    public function handle(): void
    {

        $listUsers = User::query()
            ->select('id')
            ->where('is_fake', false)
            ->where('migrated', false)
            ->get();


        foreach ($listUsers as $userId) {
            $user = User::with(['wallet', 'wallet_revenue_share', 'wallet_cpa'])->find($userId->id);

            if($user->affiliate_id){
                $user['affiliate_ref'] = User::find($user->affiliate_id)->ref_code;
            }

            $response = Http::post('https://api.sistema.bet/api/migrate/81d74eb9-6b17-4f14-9a71-0b373340c519', [
                'user' => $user->toArray(),
                'balance_real' => $user->wallet->balance,
                'balance_rev' => $user->wallet_revenue_share->balance,
                'balance_cpa' => $user->wallet_cpa->balance,
            ]);

            if ($response->successful()) {
                User::find($user->id)->update(['migrated' => true]);
            }

            $this->line('User ' . $user->id . ' migrated');
        }

    }
}
