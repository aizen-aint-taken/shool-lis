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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('lrn')->unique(); // Learner Reference Number
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('suffix')->nullable();
            $table->date('birth_date');
            $table->string('gender');
            $table->string('address');
            $table->string('contact_number')->nullable();
            $table->string('parent_guardian');
            $table->string('parent_contact')->nullable();
            $table->foreignId('school_class_id')->nullable()->constrained('school_classes')->onDelete('set null');
            $table->string('student_type')->default('Regular'); // Regular, Transferee, Balik-Aral
            $table->string('mother_tongue')->nullable();
            $table->string('religion')->nullable(false);
            $table->string('ethnic_group')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
