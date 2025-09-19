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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Book title
            $table->string('book_code')->unique(); // Unique book identifier (e.g., MTH-7-001)
            $table->string('subject'); // Subject/discipline
            $table->string('grade_level'); // Target grade level
            $table->string('publisher')->nullable(); // Publisher name
            $table->string('isbn')->nullable(); // ISBN if available
            $table->year('publication_year')->nullable(); // Year of publication
            $table->integer('total_copies')->default(1); // Total copies available
            $table->integer('available_copies')->default(1); // Available copies for distribution
            $table->enum('condition', ['new', 'good', 'fair', 'poor'])->default('good'); // Book condition
            $table->text('description')->nullable(); // Additional notes about the book
            $table->boolean('is_active')->default(true); // Active status
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['subject', 'grade_level']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
