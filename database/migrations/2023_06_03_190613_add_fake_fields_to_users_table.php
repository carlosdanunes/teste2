<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('fake_affiliate_percent_revenue_share', 14, 0)->after('affiliate_percent_revenue_share')->nullable();
            $table->decimal('fake_affiliate_percent_revenue_share_sub', 14, 0)->after('affiliate_percent_revenue_share_sub')->nullable();
            $table->decimal('fake_affiliate_cpa', 14, 0)->after('affiliate_cpa')->nullable();
            $table->decimal('fake_affiliate_cpa_sub', 14, 0)->after('affiliate_cpa_sub')->nullable();
            $table->decimal('fake_affiliate_min_deposit_cpa', 14, 0)->after('affiliate_min_deposit_cpa')->nullable();

            $table->boolean('is_fake')->default(false)->after('fake_affiliate_min_deposit_cpa');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'fake_affiliate_percent_revenue_share',
                'fake_affiliate_percent_revenue_share_sub',
                'fake_affiliate_cpa',
                'fake_affiliate_cpa_sub',
                'fake_affiliate_min_deposit_cpa',
                'is_fake',
            ]);
        });
    }
};
