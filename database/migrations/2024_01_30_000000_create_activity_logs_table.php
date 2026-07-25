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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            
            // User & Actor
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('actor_type')->nullable();
            $table->unsignedBigInteger('actor_id')->nullable();
            
            // Activity Information
            $table->string('action');
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->text('description')->nullable();
            
            // Change Tracking
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->json('properties')->nullable();
            
            // Request Information
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('method')->nullable()->comment('HTTP method');
            $table->string('url')->nullable();
            
            // Status & Risk
            $table->enum('status', ['success', 'failed', 'warning'])->default('success');
            $table->boolean('is_risky')->default(false);
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            
            $table->index('user_id');
            $table->index('action');
            $table->index('subject_type');
            $table->index('created_at');
            $table->index(['user_id', 'action', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
