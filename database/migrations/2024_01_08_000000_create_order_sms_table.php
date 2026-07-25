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
        Schema::create('order_sms', function (Blueprint $table) {
            $table->id();
            
            // References
            $table->unsignedBigInteger('order_id');
            
            // SMS Content
            $table->string('sender')->comment('Sender of the SMS');
            $table->text('message')->comment('SMS message content');
            $table->string('otp')->nullable()->comment('Extracted OTP code if present');
            
            // SMS Status
            $table->boolean('is_read')->default(false);
            $table->boolean('is_copied')->default(false);
            $table->timestamp('copied_at')->nullable();
            
            // Provider Information
            $table->string('provider_sms_id')->nullable()->comment('SMS ID from provider');
            $table->json('raw_data')->nullable()->comment('Raw SMS data from provider');
            
            // Timestamps
            $table->timestamp('received_at');
            $table->timestamps();
            
            // Indexes & Relationships
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->index('order_id');
            $table->index('received_at');
            $table->index(['order_id', 'received_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_sms');
    }
};
