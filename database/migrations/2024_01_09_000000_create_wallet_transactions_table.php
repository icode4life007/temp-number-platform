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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            
            // References
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('wallet_id');
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            
            // Transaction Details
            $table->enum('type', ['deposit', 'withdrawal', 'credit', 'debit', 'refund', 'adjustment'])->comment('Transaction type');
            $table->decimal('amount', 15, 2);
            $table->decimal('balance_before', 15, 2)->comment('Balance before transaction');
            $table->decimal('balance_after', 15, 2)->comment('Balance after transaction');
            
            // Description
            $table->string('description');
            $table->string('reference')->nullable();
            $table->text('notes')->nullable();
            
            // Status
            $table->enum('status', ['pending', 'completed', 'failed', 'reversed'])->default('pending');
            $table->string('failure_reason')->nullable();
            
            // Payment Method
            $table->string('payment_method')->nullable();
            $table->json('payment_details')->nullable();
            
            // Verification
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Indexes & Relationships
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('set null');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            
            $table->index('user_id');
            $table->index('status');
            $table->index('type');
            $table->index('created_at');
            $table->index(['user_id', 'status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
