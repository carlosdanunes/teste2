<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings_doubles', function (Blueprint $table) {
            $table->id();

            $table->boolean('fake_bets')->default(false);
            $table->integer('fake_bets_min')->default(1);
            $table->integer('fake_bets_max')->default(100);

            $table->integer('next_double_value')->nullable();
            $table->string('next_double_color')->nullable();

            $table->float('percent_profit_daily')->default(30);
            $table->float('percent_profit_week')->default(30);
            $table->float('percent_profit_month')->default(30);

            $table->integer('double_timer')->default(15);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings_doubles');
    }
};
