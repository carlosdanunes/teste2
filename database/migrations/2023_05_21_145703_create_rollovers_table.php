<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rollovers', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 14, 0);
            $table->decimal('count', 14, 0);
            $table->float('multiplier');
            $table->decimal('rollover_count', 14, 0);

            $table->foreignId('bonus_id')->nullable()->constrained('bonuses')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rollovers');
    }
};
