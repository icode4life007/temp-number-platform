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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            
            // Author
            $table->unsignedBigInteger('author_id');
            
            // Content
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            
            // Category
            $table->unsignedBigInteger('category_id')->nullable();
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            
            // Publishing
            $table->enum('status', ['draft', 'published', 'scheduled', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            
            // Statistics
            $table->integer('views')->default(0);
            $table->integer('comments_count')->default(0);
            $table->decimal('average_rating', 3, 2)->nullable();
            
            // Configuration
            $table->boolean('allow_comments')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes & Relationships
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('blog_categories')->onDelete('set null');
            
            $table->index('slug');
            $table->index('status');
            $table->index('published_at');
            $table->index('author_id');
            $table->index('category_id');
            $table->index(['status', 'published_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
