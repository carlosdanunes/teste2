<?php

use App\Models\Games\Mines;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('mines', 'hash')) {
            Schema::table('mines', function (Blueprint $table) {
                $table->uuid('hash')->nullable()->after('id');
            });
        }

        Mines::whereNull('hash')->get()->each(function (Mines $mines) {
            $mines->hash = \Illuminate\Support\Str::uuid();
            $mines->save();
        });

        Schema::table('mines', function (Blueprint $table) {
            $table->uuid('hash')->nullable(false)->default(DB::raw('(uuid ())'))->change();
        });
    }

    public function down(): void
    {
        Schema::table('mines', function (Blueprint $table) {
            $table->dropColumn('hash');
        });
    }
};
