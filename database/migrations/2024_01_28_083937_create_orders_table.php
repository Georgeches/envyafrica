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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')
                    ->constrained('customers')
                    ->cascadeOnDelete();
            $table->enum('status', ['pending', 'processing', 'completed', 'declined'])
                    ->default('pending');
            $table->integer('amount');
            $table->longText('notes');
            $table->decimal('shipping_price', places:2);
            $table->softDeletes();
            $table->string('number')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
