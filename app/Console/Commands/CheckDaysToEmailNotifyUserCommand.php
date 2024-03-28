<?php

namespace App\Console\Commands;

use App\Mail\Deposit\LastDepositMail;
use App\Models\Payment\Deposit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckDaysToEmailNotifyUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:deposit-days-notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where('is_fake', false)->get();
        $today = Carbon::now();
        foreach($users as $user){
            $lastDeposit = Deposit::where('user_id', $user->id)->where('status', 'approved')->orderBy('id', 'desc')->first();
            if ($lastDeposit){
                $difference = $lastDeposit->created_at->diffInDays($today);
                if ($difference == 3 || $difference == 5){
                    Mail::to($user)->send(new LastDepositMail($user->name));
                }
            }
        }
    }
}
