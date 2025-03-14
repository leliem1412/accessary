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
        Schema::create('salesorder', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->string('order_code')->unique();
            $table->decimal('tax', 20, 8);
            $table->decimal('discount', 20, 8);
            $table->decimal('netTotal', 20, 8);
            $table->text('description')->nullable();
            $table->string('payment_status')->default('Unpaid');
            $table->foreignId('created_by_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salesorder');
    }
};
