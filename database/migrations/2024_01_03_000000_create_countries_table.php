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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('name')->unique();
            $table->string('iso_code', 2)->unique()->comment('ISO 3166-1 alpha-2 code');
            $table->string('flag')->nullable()->comment('Flag emoji or icon URL');
            $table->string('currency_code', 3)->default('USD');
            $table->string('currency_name')->nullable();
            $table->string('currency_symbol')->nullable();
            
            // Configuration
            $table->decimal('exchange_rate', 15, 2)->default(1)->comment('Exchange rate to base currency');
            $table->boolean('status')->default(true);
            $table->integer('sort_order')->default(0);
            
            // Regional Information
            $table->string('phone_code')->nullable();
            $table->string('region')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index('iso_code');
            $table->index('status');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
