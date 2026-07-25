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
        Schema::create('provider_services', function (Blueprint $table) {
            $table->id();
            
            // References
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('service_id');
            
            // Pricing
            $table->decimal('cost_price', 15, 2)->comment('Cost from this provider');
            $table->decimal('profit_margin', 8, 2)->nullable()->comment('Override default margin');
            
            // Inventory
            $table->integer('available_count')->default(0);
            $table->integer('total_count')->default(0);
            
            // Configuration
            $table->string('provider_service_id')->nullable()->comment('Service ID at provider');
            $table->json('api_parameters')->nullable();
            $table->integer('priority')->default(0)->comment('Priority for this provider');
            $table->boolean('status')->default(true);
            
            // Performance
            $table->decimal('success_rate', 5, 2)->default(0);
            $table->integer('total_orders')->default(0);
            $table->timestamp('last_checked')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Indexes & Relationships
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->unique(['provider_id', 'service_id']);
            $table->index('status');
            $table->index(['provider_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_services');
    }
};
