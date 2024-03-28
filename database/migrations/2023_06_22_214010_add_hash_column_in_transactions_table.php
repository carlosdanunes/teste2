<?php

use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('transactions', 'hash')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->uuid('hash')->nullable()->after('id');
            });
        }

        Transaction::whereNull('hash')->get()->each(function (Transaction $transaction) {
            $transaction->hash = \Illuminate\Support\Str::uuid();
            $transaction->save();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->uuid('hash')->nullable(false)->default(DB::raw('(uuid ())'))->change();
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('hash');
        });
    }
};
