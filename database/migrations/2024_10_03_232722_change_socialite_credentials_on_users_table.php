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
        Schema::table('users', function (Blueprint $table) {
            $table->string('provider')->after('remember_token')->nullable();
            $table->renameColumn('github_id', 'provider_id');
            $table->renameColumn('github_token', 'provider_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['provider']);
            $table->renameColumn('provider_id', 'github_id');
            $table->renameColumn('provider_token', 'github_token');
        });
    }
};
