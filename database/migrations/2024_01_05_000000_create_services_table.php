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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('category')->nullable();
            
            // Country Reference
            $table->unsignedBigInteger('country_id');
            
            // Pricing
            $table->decimal('selling_price', 15, 2);
            $table->decimal('cost_price', 15, 2)->comment('Average cost from providers');
            $table->decimal('profit', 15, 2)->virtualAs('selling_price - cost_price');
            
            // Inventory
            $table->integer('total_stock')->default(0);
            $table->integer('available_stock')->default(0);
            $table->integer('reserved_stock')->default(0);
            $table->integer('sold_count')->default(0);
            
            // Configuration
            $table->json('api_mapping')->nullable()->comment('Mapping to provider APIs');
            $table->integer('sms_timeout')->default(600)->comment('SMS reception timeout in seconds');
            $table->boolean('status')->default(true);
            $table->integer('sort_order')->default(0);
            
            // Statistics
            $table->integer('total_orders')->default(0);
            $table->decimal('average_rating', 3, 2)->nullable();
            $table->integer('total_reviews')->default(0);
            
            // Timestamps
            $table->timestamps();
            
            // Indexes & Relationships
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->index('country_id');
            $table->index('status');
            $table->index('sort_order');
            $table->index(['country_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
