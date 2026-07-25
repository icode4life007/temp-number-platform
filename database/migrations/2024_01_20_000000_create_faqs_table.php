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
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            
            // Category
            $table->unsignedBigInteger('category_id');
            
            // Content
            $table->string('question');
            $table->text('answer');
            
            // Configuration
            $table->boolean('status')->default(true);
            $table->integer('sort_order')->default(0);
            $table->integer('views')->default(0);
            $table->integer('helpful_count')->default(0);
            $table->integer('unhelpful_count')->default(0);
            
            // Timestamps
            $table->timestamps();
            
            // Indexes & Relationships
            $table->foreign('category_id')->references('id')->on('faq_categories')->onDelete('cascade');
            
            $table->index('category_id');
            $table->index('status');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
