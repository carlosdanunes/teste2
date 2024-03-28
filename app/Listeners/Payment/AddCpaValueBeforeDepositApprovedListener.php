<?php

namespace App\Listeners\Payment;

use App\Models\Payment\Deposit;
use App\Models\User;

class AddCpaValueBeforeDepositApprovedListener
{
    public function __construct()
    {
    }

    public function handle($event): void
    {
        // Obtém o depósito e o usuário associado ao evento
        $deposit = $event->deposit;
        $user = $deposit->user;

        // Verifica se o usuário tem funções específicas que não devem receber comissões de CPA
        if (
            $user->hasRole('fake') ||
            $user->hasRole('youtuber') ||
            $user->hasRole('moderator') ||
            $user->hasRole('admin')
        ) {
            return; // Se o usuário tiver uma das funções acima, interrompe o processo
        }

        // Verifica se o usuário tem um ID de afiliado
        if ($user->affiliate_id) {
            // Obtém o usuário afiliado associado
            $affiliate = User::find($user->affiliate_id);

            // Verifica se o afiliado já recebeu a comissão de CPA
            if ($affiliate->commission_received_cpa) {
                return; // Se o afiliado já recebeu a comissão, interrompe o processo
            }

            // Verifica se o depósito atual é o primeiro depósito do usuário
            $firstDeposit = Deposit::query()
                ->where('user_id', $user->id)
                ->where('status', 'approved')
                ->where('amount', '>=', $affiliate->affiliate_min_deposit_cpa)
                ->first();

            if (!$firstDeposit || $deposit->id !== $firstDeposit->id) {
                return; // Se não for o primeiro depósito, interrompe o processo
            }

            // Concede a comissão de CPA ao afiliado
            $this->commissionCpa($user, $affiliate, 'wallet_cpa', $deposit->hash);

            // Define o indicador de que o afiliado recebeu a comissão de CPA
            $affiliate->update(['commission_received_cpa' => true]);
        }
    }

    private function commissionCpa(User $user, User $affiliate, string $type, $hash)
    {
        $amount = $affiliate->affiliate_cpa ?? 0;
        $wallet = $affiliate->$type;

        if($amount <= 0){
            return;
        }

        // Atualiza o saldo da carteira do afiliado
        $wallet->balance += $amount;
        $wallet->save();

        // Cria uma transação para registrar a comissão de CPA concedida
        $user->transaction()->create([
            'hash' => $hash,
            'amount' => $amount,
            'name' => 'affiliate_cpa',
            'type' => 'credit',
            'status' => 'approved',
            'wallet_id' => $wallet->id,
            'user_id' => $affiliate->id,
        ]);

        // Verifica se o afiliado tem um subafiliado
        if ($affiliate->affiliate_id) {
            $affiliateSub = User::find($affiliate->affiliate_id);

            // Concede a comissão de CPA ao subafiliado, se existir
            if ($affiliateSub) {
                $this->commissionCpaSub($affiliate, $affiliateSub, 'wallet_cpa', $hash);
            }
        }
    }

    private function commissionCpaSub(User $user, User $affiliate, string $type, $hash)
    {
        $amount = $affiliate->affiliate_cpa_sub ?? 0;
        $wallet = $affiliate->$type;

        if($amount <= 0) {
            return;
        }

            // Atualiza o saldo da carteira do subafiliado
        $wallet->balance += $amount;
        $wallet->save();

        // Cria uma transação para registrar a comissão de CPA do subafiliado concedida
        $user->transaction()->create([
            'hash' => $hash,
            'amount' => $amount,
            'name' => 'affiliate_cpa',
            'type' => 'credit',
            'status' => 'approved',
            'wallet_id' => $wallet->id,
            'user_id' => $affiliate->id,
        ]);
    }
}
