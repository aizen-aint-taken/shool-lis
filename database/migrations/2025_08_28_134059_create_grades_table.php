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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('school_class_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade'); // Teacher who encoded
            $table->string('grading_period'); // '1st Quarter', '2nd Quarter', etc.
            $table->decimal('score', 5, 2)->nullable(); // e.g., 85.50
            $table->decimal('final_rating', 5, 2)->nullable(); // Calculated final grade
            $table->string('remarks')->nullable(); // 'PASSED', 'FAILED', etc.
            $table->string('academic_year'); // e.g., '2025-2026'
            $table->timestamps();

            // Ensure unique grade per student, subject, grading period, and academic year
            $table->unique(['student_id', 'subject_id', 'grading_period', 'academic_year']);

            // Indexes for performance
            $table->index(['student_id', 'academic_year']);
            $table->index(['school_class_id', 'grading_period']);
            $table->index(['teacher_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
