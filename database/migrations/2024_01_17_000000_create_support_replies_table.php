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
        Schema::create('support_replies', function (Blueprint $table) {
            $table->id();
            
            // References
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger('user_id');
            
            // Reply Content
            $table->text('message');
            $table->boolean('is_internal')->default(false)->comment('Internal note not visible to user');
            
            // Status
            $table->boolean('is_admin_reply')->default(false);
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes & Relationships
            $table->foreign('ticket_id')->references('id')->on('support_tickets')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->index('ticket_id');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_replies');
    }
};
