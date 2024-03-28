<?php

namespace App\Console\Commands;

use App\Mail\Deposit\FirstDepositMail;
use App\Models\Payment\Deposit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckAndNotifyNewUserDepositCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:first-deposit-notify';

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
        $users = User::where('is_fake', false)->where('notify_first_deposit', false)->get();
        $today = Carbon::now();
        foreach($users as $user){
            $firstDeposit = Deposit::where('user_id', $user->id)->where('status', 'approved')->orderBy('id', 'desc')->first();
            if (!$firstDeposit){
                $difference = $user->created_at->diffInMinutes($today);
                if ($difference == 30){
                    Mail::to($user)->send(new FirstDepositMail($user->name));
                }
            }else{
                //update this variable to not check this user again
                $user->update(['notify_first_deposit', true]);
            }
        }
    }
}
