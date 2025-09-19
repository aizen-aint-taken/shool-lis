<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'book_code',
        'subject',
        'grade_level',
        'publisher',
        'isbn',
        'publication_year',
        'total_copies',
        'available_copies',
        'condition',
        'description',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'publication_year' => 'integer',
        'total_copies' => 'integer',
        'available_copies' => 'integer',
    ];

    /**
     * Get all book issues for this book.
     */
    public function bookIssues(): HasMany
    {
        return $this->hasMany(BookIssue::class);
    }

    /**
     * Get currently issued books (not returned).
     */
    public function currentIssues(): HasMany
    {
        return $this->hasMany(BookIssue::class)->where('status', 'issued');
    }

    /**
     * Get returned books.
     */
    public function returnedIssues(): HasMany
    {
        return $this->hasMany(BookIssue::class)->where('status', 'returned');
    }

    /**
     * Get lost or damaged books.
     */
    public function lostOrDamagedIssues(): HasMany
    {
        return $this->hasMany(BookIssue::class)->whereIn('status', ['lost', 'damaged']);
    }

    /**
     * Scope to get books for a specific grade level.
     */
    public function scopeForGrade($query, $gradeLevel)
    {
        return $query->where('grade_level', $gradeLevel);
    }

    /**
     * Scope to get books for a specific subject.
     */
    public function scopeForSubject($query, $subject)
    {
        return $query->where('subject', $subject);
    }

    /**
     * Scope to get active books only.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if book is available for issue.
     */
    public function isAvailable(): bool
    {
        return $this->is_active && $this->available_copies > 0;
    }

    /**
     * Update available copies when a book is issued.
     */
    public function decrementAvailableCopies(): bool
    {
        if ($this->available_copies > 0) {
            $this->decrement('available_copies');
            return true;
        }
        return false;
    }

    /**
     * Update available copies when a book is returned.
     */
    public function incrementAvailableCopies(): void
    {
        if ($this->available_copies < $this->total_copies) {
            $this->increment('available_copies');
        }
    }
}
