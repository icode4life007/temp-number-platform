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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            
            // Payment Gateway Information
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            
            // Configuration
            $table->enum('type', ['card', 'bank', 'wallet', 'other'])->default('card');
            $table->string('gateway');
            $table->json('credentials')->comment('Encrypted gateway credentials');
            $table->json('settings')->nullable();
            
            // Fees & Limits
            $table->decimal('transaction_fee', 8, 2)->default(0)->comment('Transaction fee in percentage');
            $table->decimal('fixed_fee', 15, 2)->default(0)->comment('Fixed fee per transaction');
            $table->decimal('min_amount', 15, 2)->default(1);
            $table->decimal('max_amount', 15, 2)->default(9999999);
            $table->boolean('supports_installments')->default(false);
            
            // Status
            $table->boolean('status')->default(true);
            $table->boolean('is_test_mode')->default(false);
            $table->integer('sort_order')->default(0);
            
            // Statistics
            $table->integer('total_transactions')->default(0);
            $table->decimal('total_volume', 15, 2)->default(0);
            $table->decimal('total_fees', 15, 2)->default(0);
            $table->decimal('success_rate', 5, 2)->default(0);
            
            // Timestamps
            $table->timestamps();
            $table->timestamp('last_verified')->nullable();
            
            // Indexes
            $table->index('status');
            $table->index('type');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
