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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            
            // API Configuration
            $table->string('api_url');
            $table->text('api_key')->comment('Encrypted API key');
            $table->json('api_credentials')->nullable()->comment('Additional API credentials');
            
            // Financial Configuration
            $table->decimal('balance', 15, 2)->default(0)->comment('Current provider balance');
            $table->decimal('default_profit_margin', 8, 2)->default(30)->comment('Default profit margin in percentage');
            
            // Health & Performance
            $table->enum('status', ['active', 'inactive', 'maintenance', 'deprecated'])->default('active');
            $table->enum('health_status', ['healthy', 'degraded', 'down'])->default('healthy');
            $table->integer('priority')->default(0)->comment('Priority for selection (higher = more preferred)');
            $table->integer('timeout')->default(30)->comment('API timeout in seconds');
            $table->integer('max_retries')->default(3);
            
            // Statistics
            $table->integer('total_orders')->default(0);
            $table->integer('successful_orders')->default(0);
            $table->integer('failed_orders')->default(0);
            $table->decimal('success_rate', 5, 2)->default(0);
            $table->decimal('average_response_time', 10, 2)->default(0)->comment('In milliseconds');
            
            // Timestamps
            $table->timestamps();
            $table->timestamp('last_health_check')->nullable();
            $table->timestamp('last_sync')->nullable();
            
            // Indexes
            $table->index('status');
            $table->index('health_status');
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
