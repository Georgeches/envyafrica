<?php

use App\Enums\OrderStatusEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->enum('status', ['pending', 'processing', 'delivering', 'completed', 'declined'])
                    ->default('pending');
            $table->decimal('amount', places:2);
            $table->longText('notes')
                    ->nullable();
            $table->decimal('shipping_price', places:2);
            $table->softDeletes();
            $table->string('number')->unique();
            $table->foreignId('payment_id')
                ->nullable()
                ->constrained('payments')
                ->cascadeOnDelete();
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
