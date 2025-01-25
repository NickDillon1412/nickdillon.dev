<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::table('tag_transaction', function (Blueprint $table) {
            $table->dropForeign(['transaction_id']);
            $table->foreign('transaction_id')->references('id')->on('transactions')->cascadeOnDelete();

            $table->dropForeign(['tag_id']);
            $table->foreign('tag_id')->references('id')->on('tags')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('tag_transaction', function (Blueprint $table) {
            $table->dropForeign(['transaction_id']);
            $table->foreign('transaction_id')->references('id')->on('transactions');

            $table->dropForeign(['tag_id']);
            $table->foreign('tag_id')->references('id')->on('tags');
        });
    }
};
