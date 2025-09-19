<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Attendance extends Model
{
    protected $fillable = [
        'student_id',
        'school_class_id',
        'adviser_id',
        'attendance_date',
        'status',
        'time_in',
        'time_out',
        'remarks',
        'academic_year',
        'period'
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'time_in' => 'datetime:H:i',
        'time_out' => 'datetime:H:i',
    ];

    // Relationships
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function adviser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'adviser_id');
    }

    // Scopes
    public function scopeForClass($query, $classId)
    {
        return $query->where('school_class_id', $classId);
    }

    public function scopeForStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    public function scopeForDate($query, $date)
    {
        return $query->where('attendance_date', $date);
    }

    public function scopeForDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('attendance_date', [$startDate, $endDate]);
    }

    public function scopeForAcademicYear($query, $academicYear)
    {
        return $query->where('academic_year', $academicYear);
    }

    public function scopePresent($query)
    {
        return $query->where('status', 'present');
    }

    public function scopeAbsent($query)
    {
        return $query->where('status', 'absent');
    }

    public function scopeLate($query)
    {
        return $query->where('status', 'late');
    }

    // Helper methods
    public function isPresent(): bool
    {
        return $this->status === 'present';
    }

    public function isAbsent(): bool
    {
        return $this->status === 'absent';
    }

    public function isLate(): bool
    {
        return $this->status === 'late';
    }

    public function isExcused(): bool
    {
        return $this->status === 'excused';
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'present' => 'bg-green-100 text-green-800',
            'absent' => 'bg-red-100 text-red-800',
            'late' => 'bg-yellow-100 text-yellow-800',
            'excused' => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getFormattedDate(): string
    {
        return $this->attendance_date->format('M d, Y');
    }

    public function getFormattedTimeIn(): string
    {
        return $this->time_in ? $this->time_in->format('H:i') : '-';
    }

    public function getFormattedTimeOut(): string
    {
        return $this->time_out ? $this->time_out->format('H:i') : '-';
    }

    // Static methods for calculations
    public static function getAttendanceStatsForStudent($studentId, $academicYear = '2025-2026')
    {
        $total = self::forStudent($studentId)->forAcademicYear($academicYear)->count();
        $present = self::forStudent($studentId)->forAcademicYear($academicYear)->present()->count();
        $absent = self::forStudent($studentId)->forAcademicYear($academicYear)->absent()->count();
        $late = self::forStudent($studentId)->forAcademicYear($academicYear)->late()->count();
        $excused = self::forStudent($studentId)->forAcademicYear($academicYear)->where('status', 'excused')->count();

        return [
            'total' => $total,
            'present' => $present,
            'absent' => $absent,
            'late' => $late,
            'excused' => $excused,
            'attendance_rate' => $total > 0 ? round(($present / $total) * 100, 2) : 0
        ];
    }

    public static function getAttendanceStatsForClass($classId, $academicYear = '2025-2026')
    {
        $total = self::forClass($classId)->forAcademicYear($academicYear)->count();
        $present = self::forClass($classId)->forAcademicYear($academicYear)->present()->count();
        $absent = self::forClass($classId)->forAcademicYear($academicYear)->absent()->count();
        $late = self::forClass($classId)->forAcademicYear($academicYear)->late()->count();
        $excused = self::forClass($classId)->forAcademicYear($academicYear)->where('status', 'excused')->count();

        return [
            'total' => $total,
            'present' => $present,
            'absent' => $absent,
            'late' => $late,
            'excused' => $excused,
            'attendance_rate' => $total > 0 ? round(($present / $total) * 100, 2) : 0
        ];
    }

    public static function getDailyAttendanceForClass($classId, $date, $academicYear = '2025-2026')
    {
        return self::with(['student'])
            ->forClass($classId)
            ->forDate($date)
            ->forAcademicYear($academicYear)
            ->get();
    }

    public static function getMonthlyAttendanceForStudent($studentId, $year, $month, $academicYear = '2025-2026')
    {
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        return self::forStudent($studentId)
            ->forDateRange($startDate, $endDate)
            ->forAcademicYear($academicYear)
            ->orderBy('attendance_date')
            ->get();
    }
}