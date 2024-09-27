<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vaults', function (Blueprint $table) {
            $table->integer('runtime')->after('genres')->nullable();
            $table->integer('seasons')->after('runtime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vaults', function (Blueprint $table) {
            $table->dropColumn('runtime');
            $table->dropColumn('seasons');
        });
    }
};
