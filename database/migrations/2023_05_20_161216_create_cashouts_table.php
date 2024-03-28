<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cashouts', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('external_id')->nullable();
            $table->decimal('amount', 14,0);
            $table->string('pix_key')->nullable();
            $table->string('pix_key_type')->nullable();
            $table->text('observation')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('wallet_id')->constrained('wallets');
            $table->foreignId('gateway_id')->nullable()->constrained('gateways');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cashouts');
    }
};
