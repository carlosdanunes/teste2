<?php

use App\Models\Bonus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('bonuses', 'hash')) {
            Schema::table('bonuses', function (Blueprint $table) {
                $table->uuid('hash')->nullable()->after('id');
            });
        }

        Bonus::whereNull('hash')->get()->each(function (Bonus $bonuses) {
            $bonuses->hash = \Illuminate\Support\Str::uuid();
            $bonuses->save();
        });

        Schema::table('bonuses', function (Blueprint $table) {
            $table->uuid('hash')->nullable(false)->default(DB::raw('(uuid ())'))->change();
        });
    }

    public function down(): void
    {
        Schema::table('bonuses', function (Blueprint $table) {
            $table->dropColumn('hash');
        });
    }
};
