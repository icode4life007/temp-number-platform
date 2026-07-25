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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            
            // Configuration
            $table->string('key')->unique();
            $table->string('group')->nullable()->comment('Setting group');
            $table->longText('value')->nullable();
            $table->string('value_type')->default('string')->comment('string, integer, boolean, json, array');
            
            // Metadata
            $table->text('description')->nullable();
            $table->boolean('is_editable')->default(true);
            $table->boolean('is_encrypted')->default(false);
            $table->boolean('is_public')->default(false);
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index('key');
            $table->index('group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
