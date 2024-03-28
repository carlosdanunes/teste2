<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('affiliate_min_deposit_cpa', 14, 0)->default(2000)->change();
            $table->decimal('fake_affiliate_min_deposit_cpa', 14, 0)->default(2000)->after('affiliate_min_deposit_cpa')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
