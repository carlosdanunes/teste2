<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('affiliate_percent_revenue_share', 14, 0)->default(20)->change();
            $table->decimal('affiliate_percent_revenue_share_sub', 14, 0)->default(5)->change();

            $table->decimal('affiliate_cpa', 14, 0)->default(0)->change();
            $table->decimal('affiliate_cpa_sub', 14, 0)->default(5)->change();
            $table->decimal('affiliate_min_deposit_cpa', 14, 0)->default(20)->change();

            $table->decimal('fake_affiliate_percent_revenue_share', 14, 0)->default(20)->after('affiliate_percent_revenue_share')->nullable()->change();
            $table->decimal('fake_affiliate_percent_revenue_share_sub', 14, 0)->default(5)->after('affiliate_percent_revenue_share_sub')->nullable()->change();
            $table->decimal('fake_affiliate_cpa', 14, 0)->default(0)->after('affiliate_cpa')->nullable()->change();
            $table->decimal('fake_affiliate_cpa_sub', 14, 0)->default(5)->after('affiliate_cpa_sub')->nullable()->change();
            $table->decimal('fake_affiliate_min_deposit_cpa', 14, 0)->default(20)->after('affiliate_min_deposit_cpa')->nullable()->change();

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
