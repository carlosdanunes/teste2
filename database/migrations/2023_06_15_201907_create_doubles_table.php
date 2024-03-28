<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('doubles', function (Blueprint $table) {
            $table->id();
            $table->uuid('hash');

            $table->decimal('winning_number', 10, 0);
            $table->string('winning_color')->nullable();

            $table->string('status')->default('pending');
            $table->timestamp('pending_at')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doubles');
    }
};
