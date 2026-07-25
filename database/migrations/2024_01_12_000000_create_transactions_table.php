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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            
            // References
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            
            // Transaction Details
            $table->enum('type', ['debit', 'credit'])->comment('Transaction type');
            $table->decimal('amount', 15, 2);
            $table->string('description');
            $table->string('reference')->nullable();
            
            // Category
            $table->enum('category', [
                'order',
                'refund',
                'deposit',
                'withdrawal',
                'bonus',
                'adjustment',
                'other'
            ])->default('other');
            
            // Status
            $table->enum('status', ['pending', 'completed', 'failed', 'reversed'])->default('completed';
            
            // Balances
            $table->decimal('balance_before', 15, 2);
            $table->decimal('balance_after', 15, 2);
            
            // Source Information
            $table->string('source_type')->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->json('metadata')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Indexes & Relationships
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('set null');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            
            $table->index('user_id');
            $table->index('type');
            $table->index('category');
            $table->index('status');
            $table->index('created_at');
            $table->index(['user_id', 'created_at']);
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
