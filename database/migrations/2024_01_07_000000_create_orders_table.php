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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            // References
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('provider_id');
            $table->string('provider_order_id')->nullable()->comment('Order ID from provider');
            
            // Order Details
            $table->string('number')->unique()->comment('The rented phone number');
            $table->string('number_type')->default('temp')->comment('temp, rental, dedicated');
            
            // Pricing
            $table->decimal('cost_price', 15, 2)->comment('Cost from provider');
            $table->decimal('selling_price', 15, 2)->comment('Price charged to user');
            $table->decimal('profit', 15, 2)->virtualAs('selling_price - cost_price');
            
            // SMS Information
            $table->integer('sms_count')->default(0)->comment('Total SMS received');
            $table->integer('max_sms')->nullable()->comment('Maximum allowed SMS');
            
            // Timing
            $table->timestamp('reserved_at')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('expires_at');
            $table->timestamp('extended_until')->nullable();
            
            // Status
            $table->enum('status', [
                'pending',
                'waiting_sms',
                'completed',
                'expired',
                'cancelled',
                'refunded',
                'failed'
            ])->default('pending');
            
            // Additional Options
            $table->boolean('is_renewable')->default(true);
            $table->integer('renewal_period_days')->nullable();
            $table->boolean('is_auto_renew')->default(false);
            $table->boolean('allow_call_forwarding')->default(false);
            
            // Cancellation/Refund
            $table->string('cancellation_reason')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->decimal('refund_amount', 15, 2)->nullable();
            $table->timestamp('refunded_at')->nullable();
            
            // API Integration
            $table->json('api_response')->nullable()->comment('Last API response');
            $table->string('error_message')->nullable();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes & Relationships
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('restrict');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('restrict');
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('restrict');
            
            $table->index('user_id');
            $table->index('status');
            $table->index('provider_order_id');
            $table->index('expires_at');
            $table->index('created_at');
            $table->index(['user_id', 'status']);
            $table->index(['status', 'expires_at']);
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
