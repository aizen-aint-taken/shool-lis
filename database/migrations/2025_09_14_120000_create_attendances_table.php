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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('school_class_id');
            $table->unsignedBigInteger('adviser_id'); // Who recorded the attendance
            $table->date('attendance_date');
            $table->enum('status', ['present', 'absent', 'late', 'excused'])->default('present');
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->text('remarks')->nullable();
            $table->string('academic_year', 20)->default('2025-2026');
            $table->enum('period', ['morning', 'afternoon', 'whole_day'])->default('whole_day');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('school_class_id')->references('id')->on('school_classes')->onDelete('cascade');
            $table->foreign('adviser_id')->references('id')->on('users')->onDelete('cascade');
            
            // Unique constraint to prevent duplicate attendance for same student on same date
            $table->unique(['student_id', 'attendance_date', 'period'], 'unique_student_attendance');
            
            // Indexes for better performance
            $table->index(['attendance_date', 'school_class_id']);
            $table->index(['student_id', 'academic_year']);
            $table->index(['adviser_id', 'attendance_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};