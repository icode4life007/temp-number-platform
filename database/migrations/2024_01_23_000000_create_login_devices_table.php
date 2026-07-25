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
        Schema::create('login_devices', function (Blueprint $table) {
            $table->id();
            
            // User Reference
            $table->unsignedBigInteger('user_id');
            
            // Device Information
            $table->string('device_name');
            $table->string('device_type')->nullable()->comment('mobile, desktop, tablet');
            $table->string('device_id')->nullable()->comment('Device fingerprint');
            
            // Browser & OS
            $table->string('browser')->nullable();
            $table->string('browser_version')->nullable();
            $table->string('os')->nullable();
            $table->string('os_version')->nullable();
            
            // Network Information
            $table->string('ip_address');
            $table->string('user_agent');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('timezone')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            
            // Status
            $table->boolean('is_trusted')->default(false);
            $table->timestamp('last_used_at')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Indexes & Relationships
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->index('user_id');
            $table->index('device_id');
            $table->index('is_trusted');
            $table->index('last_used_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_devices');
    }
};
