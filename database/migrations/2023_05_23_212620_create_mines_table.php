<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mines', function (Blueprint $table) {
            $table->id();
            $table->decimal('bet', 14, 0);
            $table->string('balance_type');
            $table->integer('number_of_bombs');


            $table->json('bombs');
            $table->json('clicks');

            $table->float('payout_multiplier')->default(1);
            $table->float('payout_multiplier_on_next')->default(1);

            $table->boolean('finish')->default(false);
            $table->boolean('win')->default(false);

            $table->foreignId('user_id')->constrained();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mines');
    }
};
