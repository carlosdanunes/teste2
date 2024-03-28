<?php

use App\Models\Payment\Deposit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('deposits', 'hash')) {
            Schema::table('deposits', function (Blueprint $table) {
                $table->uuid('hash')->nullable()->after('id');
            });
        }

        Deposit::whereNull('hash')->get()->each(function (Deposit $deposits) {
            $deposits->hash = \Illuminate\Support\Str::uuid();
            $deposits->save();
        });

        Schema::table('deposits', function (Blueprint $table) {
            $table->uuid('hash')->nullable(false)->default(DB::raw('(uuid ())'))->change();
        });
    }

    public function down(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn('hash');
        });
    }
};
