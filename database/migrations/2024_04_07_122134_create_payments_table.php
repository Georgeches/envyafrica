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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code');
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();
            $table->decimal('amount', places: 2);
            $table->string('phone');
            $table->enum('status', ['pending', 'success', 'failed','cancelled','refunded'])
                    ->default('pending');
            $table->string('transaction_mpesa_receipt')->nullable();
            $table->string('transaction_date')->default(\Illuminate\Support\Carbon::now()->timezone(env('TIMEZONE'))->format('d/m/Y'));
            $table->string('transaction_time')->default(\Illuminate\Support\Carbon::now()->timezone(env('TIMEZONE'))->format('g:i A'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
