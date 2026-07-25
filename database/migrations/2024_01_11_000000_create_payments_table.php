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
            
            // References
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('payment_method_id');
            $table->unsignedBigInteger('order_id')->nullable();
            
            // Payment Details
            $table->string('payment_reference')->unique()->comment('Unique payment reference');
            $table->string('gateway_reference')->nullable()->comment('Reference from payment gateway');
            
            // Amount Information
            $table->decimal('amount', 15, 2);
            $table->decimal('fee', 15, 2)->default(0);
            $table->decimal('net_amount', 15, 2)->virtualAs('amount - fee');
            $table->string('currency', 3)->default('USD');
            
            // Payment Status
            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'failed',
                'cancelled',
                'refunded',
                'partially_refunded'
            ])->default('pending');
            $table->string('failure_reason')->nullable();
            
            // Timing
            $table->timestamp('initiated_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            
            // Verification
            $table->json('verification_data')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            
            // Gateway Response
            $table->json('gateway_response')->nullable();
            $table->string('response_code')->nullable();
            $table->text('response_message')->nullable();
            
            // Webhook
            $table->boolean('webhook_received')->default(false);
            $table->timestamp('webhook_received_at')->nullable();
            $table->string('webhook_signature')->nullable();
            
            // Metadata
            $table->json('metadata')->nullable();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes & Relationships
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('restrict');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            
            $table->index('user_id');
            $table->index('status');
            $table->index('payment_reference');
            $table->index('gateway_reference');
            $table->index('created_at');
            $table->index(['user_id', 'status', 'created_at']);
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
