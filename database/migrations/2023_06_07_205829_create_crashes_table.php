<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('crashes', function (Blueprint $table) {
            $table->id();
            $table->uuid('hash');
            $table->decimal('multiplier', 10, 2)->default(1.0);
            $table->decimal('multiplier_crashed', 10, 2)->default(1.0);
            $table->string('status')->default('pending');
            $table->timestamp('pending_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crashes');
    }
};
