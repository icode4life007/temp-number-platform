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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            
            // Role Information
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->text('description')->nullable();
            
            // Configuration
            $table->boolean('is_system_role')->default(false)->comment('System roles cannot be deleted');
            $table->enum('type', ['admin', 'user', 'support', 'custom'])->default('custom');
            $table->integer('priority')->default(0);
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index('name');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
