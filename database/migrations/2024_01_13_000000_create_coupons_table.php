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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            
            // Coupon Information
            $table->string('code')->unique();
            $table->text('description')->nullable();
            
            // Discount Configuration
            $table->enum('discount_type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('discount_value', 15, 2);
            $table->decimal('max_discount', 15, 2)->nullable()->comment('Maximum discount amount');
            
            // Constraints
            $table->decimal('minimum_deposit', 15, 2)->default(0);
            $table->decimal('minimum_purchase', 15, 2)->default(0);
            $table->integer('usage_limit')->nullable()->comment('Total usage limit');
            $table->integer('per_user_limit')->default(1)->comment('Per user usage limit');
            
            // Time Constraints
            $table->timestamp('starts_at');
            $table->timestamp('expires_at');
            
            // Specific Targeting
            $table->json('applicable_services')->nullable()->comment('Specific services it applies to');
            $table->json('applicable_countries')->nullable()->comment('Specific countries it applies to');
            $table->json('applicable_users')->nullable()->comment('Specific users it applies to');
            
            // Status
            $table->boolean('status')->default(true);
            $table->boolean('is_stackable')->default(false);
            
            // Statistics
            $table->integer('total_used')->default(0);
            $table->decimal('total_discount_given', 15, 2)->default(0);
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index('code');
            $table->index('status');
            $table->index(['status', 'expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
