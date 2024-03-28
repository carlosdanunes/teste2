<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('games_user', function (Blueprint $table) {
            $table->foreignId('games_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('token');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games_users');
    }
};
