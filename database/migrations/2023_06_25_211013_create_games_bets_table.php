<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('games_bets', function (Blueprint $table) {
            $table->id();
            $table->uuid('hash')->nullable(false)->default(DB::raw('(uuid ())'));
            $table->string('parent_bet_id');
            $table->string('bet_id')->unique();
            $table->foreignId('user_id')->constrained();
            $table->decimal('bet', 14, 0);
            $table->string('balance_type');
            $table->float('payout_multiplier')->default(1);
            $table->boolean('win')->default(false);
            $table->boolean('fake')->default(false);
            $table->timestamps();

            $table->foreignId('game_id')->nullable()->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games_bets');
    }
};
