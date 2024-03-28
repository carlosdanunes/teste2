<?php

namespace Database\Seeders;

use App\Models\Games;
use App\Models\GamesProvider;
use Illuminate\Database\Seeder;

class GamesProviderSeeder extends Seeder
{
    public function run(): void
    {
        $gamesProvider = GamesProvider::updateOrCreate([
            'name' => 'PGSoft',
            'slug' => 'pgsoft',
        ], [
            'fields' => [
                "api_key",
                "api_secret"
            ],
        ]);


        Games::create([
            'name' => 'Mahjong Ways',
            'game_id' => 65,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Mahjong Ways 2',
            'game_id' => 74,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Treasures of Aztec',
            'game_id' => 87,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Leprechaun Riches',
            'game_id' => 60,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Lucky Neko',
            'game_id' => 89,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Captains Bounty',
            'game_id' => 54,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Queen of Bounty',
            'game_id' => 84,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Wild Bandito',
            'game_id' => 104,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Ways of the Qilin',
            'game_id' => 106,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Dragon Hatch',
            'game_id' => 57,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Double Fortune',
            'game_id' => 48,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'The Great Icescape',
            'game_id' => 53,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Caishen Wins',
            'game_id' => 71,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Ganesha Fortune',
            'game_id' => 75,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Dreams of Macau',
            'game_id' => 79,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Fortune Ox',
            'game_id' => 98,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Wild Bounty Showdown',
            'game_id' => 135,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Prosperity Fortune Tree',
            'game_id' => 1312883,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Diner Delights',
            'game_id' => 1372643,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Egypts Book of Mystery',
            'game_id' => 73,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Phoenix Rises',
            'game_id' => 82,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Wild Fireworks',
            'game_id' => 83,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Thai River Wonders',
            'game_id' => 92,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Bali Vacation',
            'game_id' => 94,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Crypto Gold',
            'game_id' => 103,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Jurassic Kingdom',
            'game_id' => 110,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Cocktail Nights',
            'game_id' => 117,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Fortune Tiger',
            'game_id' => 126,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Speed Winner',
            'game_id' => 127,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Legend of Perseus',
            'game_id' => 128,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Honey Trap of Diao Chan',
            'game_id' => 1,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Fortune Gods',
            'game_id' => 3,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Win Win Won',
            'game_id' => 24,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Medusa II',
            'game_id' => 6,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Tree of Fortune',
            'game_id' => 26,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Medusa',
            'game_id' => 7,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Plushie Frenzy',
            'game_id' => 25,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Gem Saviour',
            'game_id' => 2,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Hood vs Wolf',
            'game_id' => 18,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Hotpot',
            'game_id' => 28,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Dragon Legend',
            'game_id' => 29,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Mr. Hallow-Win',
            'game_id' => 35,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Legend of Hou Yi',
            'game_id' => 34,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Prosperity Lion',
            'game_id' => 36,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Hip Hop Panda',
            'game_id' => 33,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Santas Gift Rush',
            'game_id' => 37,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Baccarat Deluxe',
            'game_id' => 31,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Gem Saviour Sword',
            'game_id' => 38,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Piggy Gold',
            'game_id' => 39,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Symbols of Egypt',
            'game_id' => 41,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Emperors Favour',
            'game_id' => 44,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Ganesha Gold',
            'game_id' => 42,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Jungle Delight',
            'game_id' => 40,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Journey to the Wealth',
            'game_id' => 50,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Flirting Scholar',
            'game_id' => 61,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Ninja vs Samurai',
            'game_id' => 59,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Muay Thai Champion',
            'game_id' => 64,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Dragon Tiger Luck',
            'game_id' => 63,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Fortune Mouse',
            'game_id' => 68,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Reel Love',
            'game_id' => 20,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Gem Saviour Conquest',
            'game_id' => 62,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Shaolin Soccer',
            'game_id' => 67,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Candy Burst',
            'game_id' => 70,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Bikini Paradise',
            'game_id' => 69,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Genies 3 Wishes',
            'game_id' => 85,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Circus Delight',
            'game_id' => 80,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Secrets of Cleopatra',
            'game_id' => 90,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Vampires Charm',
            'game_id' => 58,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Jewels of Prosperity',
            'game_id' => 88,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Jack Frosts Winter',
            'game_id' => 97,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Galactic Gems',
            'game_id' => 86,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Guardians of Ice and Fire',
            'game_id' => 91,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Opera Dynasty',
            'game_id' => 93,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Majestic Treasures',
            'game_id' => 95,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Candy Bonanza',
            'game_id' => 100,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Heist  Stakes',
            'game_id' => 105,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Rise of Apollo',
            'game_id' => 101,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Mermaid Riches',
            'game_id' => 102,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Raider Janes Crypt of Fortune',
            'game_id' => 113,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Supermarket Spree',
            'game_id' => 115,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Buffalo Win',
            'game_id' => 108,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Legendary Monkey King',
            'game_id' => 107,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Spirited Wonders',
            'game_id' => 119,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Emoji Riches',
            'game_id' => 114,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Mask Carnival',
            'game_id' => 118,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Oriental Prosperity',
            'game_id' => 112,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Garuda Gems',
            'game_id' => 122,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Destiny of Sun & Moon',
            'game_id' => 121,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Butterfly Blossom',
            'game_id' => 125,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Rooster Rumble',
            'game_id' => 123,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'The Queens Banquet',
            'game_id' => 120,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Battleground Royale',
            'game_id' => 124,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Win Win Fish Prawn Crab',
            'game_id' => 129,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Lucky Piggy',
            'game_id' => 130,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Wild Coaster',
            'game_id' => 132,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Totem Wonders',
            'game_id' => 1338274,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Alchemy Gold',
            'game_id' => 1368367,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Asgardian Rising',
            'game_id' => 1340277,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Midas Fortune',
            'game_id' => 1402846,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Fortune Rabbit',
            'game_id' => 1543462,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Rave Party Fever',
            'game_id' => 1420892,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Hawaiian Tiki',
            'game_id' => 1381200,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Bakery Bonanza',
            'game_id' => 1418544,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Songkran Splash',
            'game_id' => 1448762,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Mystical Spirits',
            'game_id' => 1432733,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Super Golf Drive',
            'game_id' => 1513328,
            'games_providers_id' => $gamesProvider->id,
        ]);

        Games::create([
            'name' => 'Lucky Clover Lady',
            'game_id' => 1601012,
            'games_providers_id' => $gamesProvider->id,
        ]);

    }
}
