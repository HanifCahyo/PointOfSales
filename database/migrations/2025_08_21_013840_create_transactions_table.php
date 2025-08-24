<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no', 30)->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('total_amount', 12, 2);
            $table->enum('payment_method', ['cash', 'card', 'ewallet'])->nullable();
            $table->enum('status', ['completed', 'pending', 'refunded'])->default('completed');
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
