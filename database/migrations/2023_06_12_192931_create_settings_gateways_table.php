<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings_gateways', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gateway_id')->constrained();
            $table->boolean('is_active')->default(false);
            $table->json('credentials')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings_gateways');
    }
};
