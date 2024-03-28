<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('settings_doubles', function (Blueprint $table) {
            $table->boolean('fewer_bets_active')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('settings_doubles', function (Blueprint $table) {
            $table->dropColumn('fewer_bets_active');
        });
    }
};
