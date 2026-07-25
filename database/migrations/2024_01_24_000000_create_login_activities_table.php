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
        Schema::create('login_activities', function (Blueprint $table) {
            $table->id();
            
            // User Reference
            $table->unsignedBigInteger('user_id')->nullable();
            
            // Login Information
            $table->string('email')->nullable();
            $table->boolean('success')->default(false);
            $table->string('failure_reason')->nullable();
            
            // Device & Network
            $table->string('ip_address');
            $table->string('user_agent');
            $table->string('device_type')->nullable();
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            
            // Location
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            
            // Authentication Method
            $table->enum('method', ['email_password', 'google', 'github', 'two_factor'])->default('email_password');
            $table->boolean('two_factor_verified')->default(false);
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            
            $table->index('user_id');
            $table->index('email');
            $table->index('success');
            $table->index('created_at');
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_activities');
    }
};
