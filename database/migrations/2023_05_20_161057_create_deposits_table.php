<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->decimal('amount', 14,0);

            $table->string('external_id')->nullable();
            $table->string('currency');

            $table->boolean('has_bonus')->default(false);

            $table->text('pix_url')->nullable();
            $table->text('pix_qr_code')->nullable();

            $table->text('refused_reason')->nullable();

            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('wallet_id')->constrained('wallets');
            $table->foreignId('gateway_id')->nullable()->constrained('gateways');

            $table->foreignId('created_by')->nullable()->constrained('users');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
