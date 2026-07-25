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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            
            // Authentication
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->boolean('is_email_verified')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            
            // 2FA
            $table->boolean('is_2fa_enabled')->default(false);
            $table->string('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            
            // Account Status
            $table->enum('status', ['active', 'suspended', 'banned', 'inactive'])->default('active');
            $table->boolean('is_locked')->default(false);
            $table->timestamp('locked_until')->nullable();
            
            // Profile
            $table->text('bio')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('timezone')->default('UTC');
            
            // Preferences
            $table->json('preferences')->nullable();
            $table->boolean('is_dark_mode')->default(false);
            $table->boolean('receive_email_notifications')->default(true);
            $table->boolean('receive_sms_notifications')->default(true);
            
            // Referral System
            $table->unsignedBigInteger('referred_by')->nullable();
            $table->string('referral_code')->unique();
            
            // Timestamps
            $table->timestamps();
            $table->timestamp('last_login_at')->nullable();
            $table->softDeletes();
            
            // Indexes
            $table->index('status');
            $table->index('created_at');
            $table->index('referral_code');
            $table->foreign('referred_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
