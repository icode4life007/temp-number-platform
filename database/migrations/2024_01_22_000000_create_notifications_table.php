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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            
            // User Reference
            $table->unsignedBigInteger('user_id');
            
            // Notification Content
            $table->string('type');
            $table->string('title');
            $table->text('message');
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->json('data')->nullable();
            
            // Related Resource
            $table->string('notifiable_type')->nullable();
            $table->unsignedBigInteger('notifiable_id')->nullable();
            
            // Channels
            $table->boolean('send_email')->default(false);
            $table->boolean('send_sms')->default(false);
            $table->boolean('send_browser')->default(true);
            $table->boolean('send_telegram')->default(false);
            
            // Status
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->boolean('is_sent')->default(false);
            $table->timestamp('sent_at')->nullable();
            
            // Action
            $table->string('action_url')->nullable();
            $table->boolean('requires_action')->default(false);
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->index('user_id');
            $table->index('is_read');
            $table->index('type');
            $table->index('created_at');
            $table->index(['user_id', 'is_read']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
