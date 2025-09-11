<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    protected $fillable = [
        'class_name',
        'grade_level',
        'section',
        'school_year',
        'adviser_id',
        'max_students',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'max_students' => 'integer',
    ];

    // Relationships
    public function adviser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'adviser_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    // Helper methods
    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function getEnrolledCountAttribute(): int
    {
        return $this->students()->where('is_active', true)->count();
    }

    public function hasCapacity(): bool
    {
        return $this->enrolled_count < $this->max_students;
    }
}
