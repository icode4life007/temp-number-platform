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
        Schema::create('coupon_usages', function (Blueprint $table) {
            $table->id();
            
            // References
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('coupon_id');
            $table->unsignedBigInteger('order_id')->nullable();
            
            // Usage Details
            $table->decimal('discount_amount', 15, 2);
            $table->decimal('original_amount', 15, 2);
            $table->decimal('final_amount', 15, 2)->virtualAs('original_amount - discount_amount');
            
            // Timestamps
            $table->timestamp('used_at');
            $table->timestamps();
            
            // Indexes & Relationships
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            
            $table->index('user_id');
            $table->index('coupon_id');
            $table->index('used_at');
            $table->index(['user_id', 'coupon_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_usages');
    }
};
