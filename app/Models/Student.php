<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'lrn',
        'first_name',
        'last_name',
        'middle_name',
        'suffix',
        'birth_date',
        'gender',
        'address',
        'contact_number',
        'parent_guardian',
        'parent_contact',
        'school_class_id',
        'student_type',
        'mother_tongue',
        'religion',
        'ethnic_group',
        'is_active'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    // Helper methods
    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name . ' ' . $this->suffix);
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }
}
