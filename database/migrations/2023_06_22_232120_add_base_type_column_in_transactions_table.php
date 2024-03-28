<?php

use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('base_type')->nullable()->after('type');
        });

        Transaction::whereNull('base_type')->get()->each(function (Transaction $transaction) {
            $transaction->base_type = class_basename($transaction->typable_type);
            $transaction->save();
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('base_type');
        });
    }
};
