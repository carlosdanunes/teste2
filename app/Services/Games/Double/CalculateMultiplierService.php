<?php

namespace App\Services\Games\Double;

use App\Enum\DoubleWinningColor;
use App\Models\Games\Double;
use App\Models\Games\DoubleBet;
use App\Models\SettingsDouble;
use Illuminate\Support\Facades\DB;

class CalculateMultiplierService
{
    public function multiplier(): float|int
    {
        $winning_number = rand(0, 14);
        $settingsDouble = SettingsDouble::first();
        if(!$settingsDouble){
            return $winning_number;
        }
        if(!is_null($settingsDouble->next_double_value)){
            $winning_number = $settingsDouble->next_double_value;
            $settingsDouble->update([
                'next_double_value' => null,
            ]);
        }
        if(!is_null($settingsDouble->next_double_color)){
            $winning_number = DoubleWinningColor::getNumber($settingsDouble->next_double_color);
            $settingsDouble->update([
                'next_double_color' => null,
            ]);
        }
        return $winning_number;
    }


    public function getColorWithFewerBets(Double $double): string | bool
    {

        $fewerBetsActive = SettingsDouble::first()?->fewer_bets_active ?? false;

        if(!$fewerBetsActive){
            return false;
        }

        if(DoubleBet::query()->where('double_id', $double->id)->where('fake', 0)->count() == 0){
            return false;
        }

        $sumWhite = DB::table('double_bets')
            ->select(DB::raw('SUM(bet) as soma_bet'))
            ->where('fake', 0)
            ->where('double_id', $double->id)
            ->where('bet_color', 'white')
            ->first()?->soma_bet ?? 1;

        $sumGreen = DB::table('double_bets')
            ->select(DB::raw('SUM(bet) as soma_bet'))
            ->where('fake', 0)
            ->where('double_id', $double->id)
            ->where('bet_color', 'green')
            ->first()?->soma_bet ?? 0;

        $sumBlack = DB::table('double_bets')
            ->select(DB::raw('SUM(bet) as soma_bet'))
            ->where('fake', 0)
            ->where('double_id', $double->id)
            ->where('bet_color', 'black')
            ->first()?->soma_bet ?? 0;

        $sums = [
            'white' => ($sumWhite == 0 ? 1 : $sumWhite) * 14,
            'green' => $sumGreen * 2,
            'black' => $sumBlack * 2,
        ];

        //ordena o sums do menor para o maior e pga o primeiro
        asort($sums);
        $colorFewerBets = array_key_first($sums);

        return $colorFewerBets ?? $double->winning_color;
    }
}
