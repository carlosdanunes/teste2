<?php

use App\Models\Payment\Cashout;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('cashouts', 'hash')) {
            Schema::table('cashouts', function (Blueprint $table) {
                $table->uuid('hash')->nullable()->after('id');
            });
        }

        Cashout::whereNull('hash')->get()->each(function (Cashout $cashouts) {
            $cashouts->hash = \Illuminate\Support\Str::uuid();
            $cashouts->save();
        });

        Schema::table('cashouts', function (Blueprint $table) {
            $table->uuid('hash')->nullable(false)->default(DB::raw('(uuid ())'))->change();
        });
    }

    public function down(): void
    {
        Schema::table('cashouts', function (Blueprint $table) {
            $table->dropColumn('hash');
        });
    }
};
