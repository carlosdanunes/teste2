<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('gateways', function (Blueprint $table) {
            $table->dropColumn('is_active');
            $table->dropColumn('credentials');
            $table->json('fields');
        });
    }

    public function down(): void
    {
        Schema::table('gateways', function (Blueprint $table) {
            $table->boolean('is_active')->default(false);
            $table->string('name');
            $table->string('slug');
            $table->json('credentials')->nullable();
        });
    }
};
