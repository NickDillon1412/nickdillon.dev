<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PureFinance\Category;
use App\Models\PureFinance\Account;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Account::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->float('amount');
            $table->text('description');
            $table->date('date');
            $table->text('notes')->nullable();
            $table->json('attachments')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('is_recurring')->default(false);
            $table->string('frequency')->nullable();
            $table->date('recurring_end')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
