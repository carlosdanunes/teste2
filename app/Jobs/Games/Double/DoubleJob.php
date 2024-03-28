<?php

namespace App\Jobs\Games\Double;

use App\Enum\DoubleStatus;
use App\Enum\DoubleWinningColor;
use App\Events\Broadcast\Games\Double\DoubleGameEvent;
use App\Http\Resources\Games\Double\GameResource;
use App\Models\Games\Double;
use App\Models\SettingsDouble;
use App\Services\Games\Double\CalculateMultiplierService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class DoubleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $double;

    public function __construct()
    {

        $this->onQueue('double');

        $this->double = Double::query()
            ->orderByRaw('FIELD(status, "pending") DESC')
            ->orderByRaw('FIELD(status, "started") DESC')
            ->latest()
            ->first();
    }
    // public function middleware(): array
    // {
    //     return [(new WithoutOverlapping($this->double->id))->dontRelease()];
    // }
    public function handle(): void
    {
        if (!$this->double) {
            //stop job
            return;
        }
        if ($this->double->status == DoubleStatus::Finished->value) {
            if (Carbon::parse($this->double->updated_at)->addSeconds(10)->gte(Carbon::now())) {
                $sleep = Carbon::parse($this->double->updated_at)->addSeconds(6)->diffInSeconds(Carbon::now());
                sleep(($sleep < 1) ? 1 : $sleep);
            }
            $has_gaming = Double::query()
                ->where('status', DoubleStatus::Pending->value)
                ->orWhere('status', DoubleStatus::Started->value)
                ->exists();
            if (!$has_gaming) {
                $winning_number = (new CalculateMultiplierService())->multiplier();
                Double::create([
                    'hash' => Str::random(32),
                    'status' => DoubleStatus::Pending->value,
                    'pending_at' => now()->addSeconds(15),
                    'winning_number' => $winning_number,
                    'winning_color' => DoubleWinningColor::getColor($winning_number)->value,
                ]);
            }
        }
        if ($this->double->status == DoubleStatus::Started->value) {
            DoubleGameEvent::dispatch((new GameResource($this->double)));
            $this->double->update([
                'status' => DoubleStatus::Finished->value,
            ]);
            sleep(6);
            DoubleGameEvent::dispatch((new GameResource($this->double)));
            sleep(3);
            DoubleJob::dispatch();
        }
        if ($this->double->status == DoubleStatus::Pending->value) {
            if (SettingsDouble::first()->fake_bets ?? false) {
                CreateFakeBetDoubleJob::dispatch();
            }
            if (Carbon::parse($this->double->pending_at)->gte(Carbon::now())) {
                $sleep = Carbon::parse($this->double->pending_at)->diffInSeconds(Carbon::now());
                sleep(($sleep < 1) ? 1 : $sleep);
            }
            $this->double->update([
                'status' => DoubleStatus::Started->value,
            ]);

            $winning_color_fewer_bets = (new CalculateMultiplierService())->getColorWithFewerBets($this->double);

            if ($winning_color_fewer_bets !== false) {
                $this->double->update([
                    'winning_color' => $winning_color_fewer_bets,
                    'winning_number' => DoubleWinningColor::getNumber($winning_color_fewer_bets),
                ]);
            }

            DoubleJob::dispatch();
        }
    }
}