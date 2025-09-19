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
        Schema::create('book_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade'); // Reference to books table
            $table->foreignId('student_id')->constrained()->onDelete('cascade'); // Reference to students table
            $table->foreignId('school_class_id')->constrained()->onDelete('cascade'); // Reference to school_classes table
            $table->foreignId('issued_by')->constrained('users')->onDelete('cascade'); // User who issued the book (adviser/admin)
            $table->date('issue_date'); // Date when book was issued
            $table->date('expected_return_date')->nullable(); // Expected return date
            $table->date('actual_return_date')->nullable(); // Actual return date (null if not returned)
            $table->enum('issue_condition', ['new', 'good', 'fair', 'poor']); // Condition when issued
            $table->enum('return_condition', ['new', 'good', 'fair', 'poor', 'damaged', 'lost'])->nullable(); // Condition when returned
            $table->enum('status', ['issued', 'returned', 'lost', 'damaged'])->default('issued'); // Current status
            $table->text('issue_remarks')->nullable(); // Remarks when issuing
            $table->text('return_remarks')->nullable(); // Remarks when returning
            $table->decimal('penalty_amount', 8, 2)->default(0.00); // Penalty for late return or damage
            $table->boolean('penalty_paid')->default(false); // Whether penalty has been paid
            $table->string('academic_year', 9); // Academic year (e.g., '2025-2026')
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['student_id', 'academic_year']);
            $table->index(['school_class_id', 'academic_year']);
            $table->index('status');
            $table->index('issue_date');
            
            // Unique constraint to prevent duplicate book issues to same student
            $table->unique(['book_id', 'student_id', 'issue_date'], 'unique_book_student_issue');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_issues');
    }
};
