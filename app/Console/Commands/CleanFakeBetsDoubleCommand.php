<?php

namespace App\Console\Commands;

use App\Models\Games\Crash;
use App\Models\Games\CrashBet;
use App\Models\Games\Double;
use App\Models\Games\DoubleBet;
use Illuminate\Console\Command;

class CleanFakeBetsDoubleCommand extends Command
{
    protected $signature = 'clean:fake-bets-double';

    protected $description = 'Command description';

    public function handle(): void
    {
        $this->info('Cleaning fake bets...');

        DoubleBet::query()
            ->where('fake', true)
            ->whereDate('created_at', '<=', today()->subDay())
            ->forceDelete();

        $this->info('Cleaning doubles without bets...');

        Double::query()
            ->whereDoesntHave('bets')
            ->whereDate('created_at', '<=', today()->subDay())
            ->forceDelete();

        $this->info('Done!');
    }
}
