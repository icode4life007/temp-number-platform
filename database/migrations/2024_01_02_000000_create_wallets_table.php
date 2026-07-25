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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            
            // User Reference
            $table->unsignedBigInteger('user_id')->unique();
            
            // Balance Tracking
            $table->decimal('balance', 15, 2)->default(0)->comment('Current wallet balance');
            $table->decimal('total_deposits', 15, 2)->default(0)->comment('Total amount deposited');
            $table->decimal('total_withdrawals', 15, 2)->default(0)->comment('Total amount withdrawn');
            $table->decimal('total_spent', 15, 2)->default(0)->comment('Total amount spent on orders');
            $table->decimal('total_refunded', 15, 2)->default(0)->comment('Total refunds received');
            
            // Freeze & Hold
            $table->decimal('frozen_balance', 15, 2)->default(0)->comment('Temporarily frozen balance');
            $table->boolean('is_frozen')->default(false);
            $table->timestamp('frozen_until')->nullable();
            
            // Status
            $table->enum('status', ['active', 'suspended', 'closed'])->default('active');
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
