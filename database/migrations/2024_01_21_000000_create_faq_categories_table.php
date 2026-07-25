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
        Schema::create('faq_categories', function (Blueprint $table) {
            $table->id();
            
            // Information
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // Configuration
            $table->boolean('status')->default(true);
            $table->integer('sort_order')->default(0);
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index('slug');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faq_categories');
    }
};
