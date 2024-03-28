<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('affiliate_cpa_sub', 14, 0)->default(0)->change();
            $table->decimal('fake_affiliate_cpa_sub', 14, 0)->default(0)->after('affiliate_cpa_sub')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
