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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            
            // References
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('assigned_to')->nullable();
            
            // Ticket Information
            $table->string('subject');
            $table->text('description');
            $table->string('ticket_number')->unique();
            
            // Category & Priority
            $table->string('category')->default('general');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            
            // Status
            $table->enum('status', [
                'open',
                'in_progress',
                'pending_user_response',
                'pending_admin_response',
                'resolved',
                'closed',
                'reopened'
            ])->default('open');
            
            // Statistics
            $table->integer('reply_count')->default(0);
            $table->timestamp('last_replied_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            
            // Evaluation
            $table->integer('satisfaction_rating')->nullable()->comment('1-5 rating');
            $table->text('satisfaction_comment')->nullable();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes & Relationships
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
            
            $table->index('user_id');
            $table->index('status');
            $table->index('priority');
            $table->index('ticket_number');
            $table->index('created_at');
            $table->index(['status', 'priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
