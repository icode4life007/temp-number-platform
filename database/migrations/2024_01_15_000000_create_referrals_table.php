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
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            
            // References
            $table->unsignedBigInteger('referrer_id');
            $table->unsignedBigInteger('referred_id');
            
            // Commission Information
            $table->decimal('commission_rate', 5, 2)->comment('Commission percentage');
            $table->decimal('commission_amount', 15, 2)->default(0)->comment('Total commission earned');
            $table->decimal('pending_commission', 15, 2)->default(0)->comment('Pending commission');
            $table->decimal('paid_commission', 15, 2)->default(0)->comment('Already paid commission');
            
            // Referral Statistics
            $table->integer('orders_count')->default(0);
            $table->decimal('orders_total', 15, 2)->default(0);
            $table->integer('active_orders')->default(0);
            
            // Status
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            
            // Dates
            $table->timestamp('referred_at');
            $table->timestamp('first_order_at')->nullable();
            $table->timestamp('last_order_at')->nullable();
            $table->timestamp('last_commission_paid_at')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Indexes & Relationships
            $table->foreign('referrer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('referred_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->unique(['referrer_id', 'referred_id']);
            $table->index('referrer_id');
            $table->index('referred_id');
            $table->index('status');
            $table->index(['referrer_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
