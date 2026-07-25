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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            
            // Permission Information
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->text('description')->nullable();
            
            // Categorization
            $table->string('group')->nullable()->comment('Permission group/category');
            $table->string('module')->nullable()->comment('Module this permission belongs to');
            
            // Configuration
            $table->boolean('is_system_permission')->default(false)->comment('System permissions cannot be deleted');
            $table->integer('priority')->default(0);
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index('name');
            $table->index('group');
            $table->index('module');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
