<?php

use App\Models\Games\CrashBet;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('crash_bets', 'hash')) {
            Schema::table('crash_bets', function (Blueprint $table) {
                $table->uuid('hash')->nullable()->after('id');
            });
        }

        CrashBet::whereNull('hash')->get()->each(function (CrashBet $crash_bets) {
            $crash_bets->hash = \Illuminate\Support\Str::uuid();
            $crash_bets->save();
        });

        Schema::table('crash_bets', function (Blueprint $table) {
            $table->uuid('hash')->nullable(false)->default(DB::raw('(uuid ())'))->change();
        });
    }

    public function down(): void
    {
        Schema::table('crash_bets', function (Blueprint $table) {
            $table->dropColumn('hash');
        });
    }
};
