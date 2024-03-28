<?php

use App\Models\Games\DoubleBet;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('double_bets', 'hash')) {
            Schema::table('double_bets', function (Blueprint $table) {
                $table->uuid('hash')->nullable()->after('id');
            });
        }

        DoubleBet::whereNull('hash')->get()->each(function (DoubleBet $double_bets) {
            $double_bets->hash = \Illuminate\Support\Str::uuid();
            $double_bets->save();
        });

        Schema::table('double_bets', function (Blueprint $table) {
            $table->uuid('hash')->nullable(false)->default(DB::raw('(uuid ())'))->change();
        });
    }

    public function down(): void
    {
        Schema::table('double_bets', function (Blueprint $table) {
            $table->dropColumn('hash');
        });
    }
};
