<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('double_bets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained();
            $table->foreignId('double_id')->constrained();
            $table->string('bet_color');
            $table->decimal('bet', 14, 0);
            $table->string('balance_type');
            $table->float('payout_multiplier')->default(1);
            $table->boolean('win')->default(false);
            $table->boolean('fake')->default(false);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('double_bets');
    }
};
