<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('document')->unique();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('password');

            $table->date('birth_date')->nullable();

            $table->string('pix_key')->nullable();
            $table->string('pix_key_type')->nullable();

            $table->string('ref_code')->unique();

            $table->decimal('affiliate_percent_revenue_share', 14, 0)->default(60);
            $table->decimal('affiliate_percent_revenue_share_sub', 14, 0)->default(10);

            $table->decimal('affiliate_cpa', 14, 0)->default(2000);
            $table->decimal('affiliate_cpa_sub', 14, 0)->default(200);
            $table->decimal('affiliate_min_deposit_cpa', 14, 0)->default(2000);

            $table->foreignId('affiliate_id')->nullable()->constrained('users');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
