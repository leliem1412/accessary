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
        Schema::create('order_payment_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salesorder_id')->constrained('salesorder');
            $table->foreignId('customer_id')->constrained('customers');
            $table->string('payment_method');
            $table->decimal('netTotal', 20, 4);
            $table->decimal('amount', 20, 4);
            $table->foreignId('created_by_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payment_history');
    }
};
