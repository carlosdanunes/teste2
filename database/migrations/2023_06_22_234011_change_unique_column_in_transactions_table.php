<?php

use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Transaction::query()
            ->withTrashed()
            ->whereNotNull('deleted_at')
            ->forceDelete();

        Schema::table('transactions', function (Blueprint $table) {
            $table->unique(['hash', 'user_id', 'typable_id', 'type', 'base_type'], 'unico');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropUnique('unico');
        });
    }
};
