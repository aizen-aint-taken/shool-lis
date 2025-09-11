<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
        'school_class_id',
        'teacher_id',
        'grading_period',
        'score',
        'final_rating',
        'remarks',
        'academic_year'
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'final_rating' => 'decimal:2',
    ];

    // Relationships
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Helper methods
    public function isPassed(): bool
    {
        return $this->final_rating >= 75;
    }

    public function getRemarks(): string
    {
        return $this->isPassed() ? 'PASSED' : 'FAILED';
    }
}
