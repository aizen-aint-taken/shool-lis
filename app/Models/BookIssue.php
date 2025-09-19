<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class BookIssue extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'book_id',
        'student_id',
        'school_class_id',
        'issued_by',
        'issue_date',
        'expected_return_date',
        'actual_return_date',
        'issue_condition',
        'return_condition',
        'status',
        'issue_remarks',
        'return_remarks',
        'penalty_amount',
        'penalty_paid',
        'academic_year',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'issue_date' => 'date',
        'expected_return_date' => 'date',
        'actual_return_date' => 'date',
        'penalty_amount' => 'decimal:2',
        'penalty_paid' => 'boolean',
    ];

    /**
     * Get the book that was issued.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the student who received the book.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the class the student belongs to.
     */
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    /**
     * Get the user who issued the book.
     */
    public function issuedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    /**
     * Scope to get issues for a specific class.
     */
    public function scopeForClass($query, $classId)
    {
        return $query->where('school_class_id', $classId);
    }

    /**
     * Scope to get issues for a specific academic year.
     */
    public function scopeForAcademicYear($query, $academicYear)
    {
        return $query->where('academic_year', $academicYear);
    }

    /**
     * Scope to get currently issued books.
     */
    public function scopeCurrentlyIssued($query)
    {
        return $query->where('status', 'issued');
    }

    /**
     * Scope to get returned books.
     */
    public function scopeReturned($query)
    {
        return $query->where('status', 'returned');
    }

    /**
     * Scope to get lost or damaged books.
     */
    public function scopeLostOrDamaged($query)
    {
        return $query->whereIn('status', ['lost', 'damaged']);
    }

    /**
     * Check if the book issue is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->status === 'issued' && 
               $this->expected_return_date && 
               $this->expected_return_date->isPast();
    }

    /**
     * Get the number of days overdue.
     */
    public function daysOverdue(): int
    {
        if (!$this->isOverdue()) {
            return 0;
        }
        
        return $this->expected_return_date->diffInDays(Carbon::now());
    }

    /**
     * Check if the book was returned in good condition.
     */
    public function returnedInGoodCondition(): bool
    {
        return $this->status === 'returned' && 
               in_array($this->return_condition, ['new', 'good']);
    }

    /**
     * Calculate penalty amount based on condition and days overdue.
     */
    public function calculatePenalty(): float
    {
        $penalty = 0.00;
        
        // Penalty for late return (10 pesos per day)
        if ($this->isOverdue()) {
            $penalty += $this->daysOverdue() * 10.00;
        }
        
        // Penalty for damage
        if ($this->return_condition === 'damaged') {
            $penalty += 50.00; // Fixed damage penalty
        }
        
        // Penalty for lost book
        if ($this->status === 'lost') {
            $penalty += 500.00; // Replacement cost
        }
        
        return $penalty;
    }

    /**
     * Mark book as returned.
     */
    public function markAsReturned(string $condition, string $remarks = null): void
    {
        $this->update([
            'status' => 'returned',
            'actual_return_date' => Carbon::now(),
            'return_condition' => $condition,
            'return_remarks' => $remarks,
            'penalty_amount' => $this->calculatePenalty(),
        ]);
        
        // Update book availability
        $this->book->incrementAvailableCopies();
    }

    /**
     * Mark book as lost or damaged.
     */
    public function markAsLostOrDamaged(string $status, string $remarks = null): void
    {
        $this->update([
            'status' => $status,
            'return_condition' => $status,
            'return_remarks' => $remarks,
            'penalty_amount' => $this->calculatePenalty(),
        ]);
    }
}
