<?php

namespace App\Console\Commands;

use App\Models\Games\Crash;
use App\Models\Games\CrashBet;
use Illuminate\Console\Command;

class CleanFakeBetsCrashCommand extends Command
{
    protected $signature = 'clean:fake-bets-crash';

    protected $description = 'Command description';

    public function handle(): void
    {
        $this->info('Cleaning fake bets...');

        CrashBet::query()
            ->where('fake', true)
            ->whereDate('created_at', '<=', today()->subDay())
            ->forceDelete();

        $this->info('Cleaning crashes without bets...');

        Crash::query()
            ->whereDoesntHave('bets')
            ->whereDate('created_at', '<=', today()->subDay())
            ->forceDelete();

        $this->info('Done!');
    }
}
