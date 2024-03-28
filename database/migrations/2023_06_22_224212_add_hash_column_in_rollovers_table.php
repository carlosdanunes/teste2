<?php

use App\Models\Rollover;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('rollovers', 'hash')) {
            Schema::table('rollovers', function (Blueprint $table) {
                $table->uuid('hash')->nullable()->after('id');
            });
        }

        Rollover::whereNull('hash')->get()->each(function (Rollover $rollovers) {
            $rollovers->hash = \Illuminate\Support\Str::uuid();
            $rollovers->save();
        });

        Schema::table('rollovers', function (Blueprint $table) {
            $table->uuid('hash')->nullable(false)->default(DB::raw('(uuid ())'))->change();
        });
    }

    public function down(): void
    {
        Schema::table('rollovers', function (Blueprint $table) {
            $table->dropColumn('hash');
        });
    }
};
