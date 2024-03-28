<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings_game_providers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('games_providers_id')->constrained();
            $table->boolean('status')->default(true);
            $table->json('credentials');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings_game_providers');
    }
};
