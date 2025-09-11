<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'description',
        'grade_level',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    // Helper methods
    public function isActive(): bool
    {
        return $this->is_active;
    }

    // Scope for active subjects
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for specific grade level
    public function scopeForGradeLevel($query, $gradeLevel)
    {
        return $query->where('grade_level', $gradeLevel);
    }
}
