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
        Schema::create('provider_accounts', function (Blueprint $table) {
            $table->id();
            
            // References
            $table->unsignedBigInteger('provider_id');
            
            // Account Information
            $table->string('account_name')->nullable();
            $table->string('account_identifier')->nullable()->comment('Account ID at provider');
            $table->text('credentials')->comment('Encrypted account credentials');
            
            // Financial Information
            $table->decimal('balance', 15, 2)->default(0);
            $table->decimal('initial_balance', 15, 2)->default(0);
            $table->decimal('total_spent', 15, 2)->default(0);
            $table->decimal('total_earned', 15, 2)->default(0);
            
            // Health & Status
            $table->enum('status', ['active', 'inactive', 'suspended', 'limited'])->default('active');
            $table->enum('health_status', ['healthy', 'degraded', 'error'])->default('healthy');
            $table->text('health_message')->nullable();
            
            // Synchronization
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamp('last_health_check')->nullable();
            $table->integer('sync_failures')->default(0);
            
            // Rate Limiting
            $table->integer('request_limit')->nullable();
            $table->integer('request_count')->default(0);
            $table->timestamp('request_reset_at')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Indexes & Relationships
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');
            
            $table->index('provider_id');
            $table->index('status');
            $table->index('account_identifier');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_accounts');
    }
};
