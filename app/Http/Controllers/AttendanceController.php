<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/**
 * Attendance Controller
 * 
 * Handles attendance management for advisers including:
 * - Daily attendance encoding
 * - Attendance reports
 * - Attendance statistics
 * - Role-based access control
 * 
 * @author DepEd LIS System
 * @version 1.0
 */
class AttendanceController extends Controller
{
    /**
     * Show attendance dashboard for advisers and admin
     */
    public function index()
    {
        // Only advisers and admins can access attendance management
        if (!Auth::check() || !in_array(Auth::user()->role, ['adviser', 'admin'])) {
            abort(403, 'Only advisers and administrators can view attendance.');
        }

        $user = Auth::user();
        
        if ($user->role === 'admin') {
            // Admin can see all classes
            $classes = SchoolClass::with(['students', 'adviser'])->where('is_active', true)->get();
        } else {
            // Adviser can see only their classes
            $classes = $user->advisedClasses()->with('students')->get();
        }
        
        // Get today's attendance stats
        $today = Carbon::today();
        $attendanceStats = [];
        
        foreach ($classes as $class) {
            $stats = Attendance::getAttendanceStatsForClass($class->id, '2025-2026');
            $todayAttendance = Attendance::getDailyAttendanceForClass($class->id, $today);
            
            $attendanceStats[$class->id] = [
                'class' => $class,
                'overall_stats' => $stats,
                'today_total' => $todayAttendance->count(),
                'today_present' => $todayAttendance->where('status', 'present')->count(),
                'today_absent' => $todayAttendance->where('status', 'absent')->count(),
                'today_late' => $todayAttendance->where('status', 'late')->count()
            ];
        }

        return view('attendance.index', compact('attendanceStats', 'classes'));
    }

    /**
     * Show daily attendance encoding form
     */
    public function daily($classId = null)
    {
        if (!Auth::check() || !Auth::user()->isAdviser()) {
            abort(403, 'Only advisers can encode attendance.');
        }

        $adviser = Auth::user();
        $advisedClasses = $adviser->advisedClasses()->with('students')->get();
        
        // If class ID provided, validate adviser has access
        $selectedClass = null;
        if ($classId) {
            $selectedClass = $advisedClasses->where('id', $classId)->first();
            if (!$selectedClass) {
                abort(403, 'You can only manage attendance for your assigned classes.');
            }
        }

        $attendanceDate = request('date', Carbon::today()->format('Y-m-d'));
        $students = $selectedClass ? $selectedClass->students()->orderBy('last_name')->orderBy('first_name')->get() : collect();
        
        // Get existing attendance for the date
        $existingAttendance = [];
        if ($selectedClass) {
            $attendance = Attendance::forClass($selectedClass->id)
                ->where('attendance_date', $attendanceDate)
                ->get()
                ->keyBy('student_id');
            
            foreach ($attendance as $record) {
                $existingAttendance[$record->student_id] = $record;
            }
        }

        return view('attendance.daily', compact(
            'advisedClasses', 
            'selectedClass', 
            'students', 
            'attendanceDate', 
            'existingAttendance'
        ));
    }

    /**
     * Store daily attendance
     */
    public function store(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAdviser()) {
            return response()->json([
                'success' => false,
                'message' => 'Only advisers can encode attendance.'
            ], 403);
        }

        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'attendance_date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.student_id' => 'required|exists:students,id',
            'attendance.*.status' => 'required|in:present,absent,late,excused',
            'attendance.*.time_in' => 'nullable|date_format:H:i',
            'attendance.*.time_out' => 'nullable|date_format:H:i',
            'attendance.*.remarks' => 'nullable|string|max:255',
        ]);

        $adviser = Auth::user();
        $class = SchoolClass::find($request->class_id);

        // Verify adviser has access to this class
        if ($class->adviser_id !== $adviser->id) {
            return response()->json([
                'success' => false,
                'message' => 'You can only manage attendance for your assigned classes.'
            ], 403);
        }

        try {
            $savedCount = 0;
            $attendanceDate = Carbon::parse($request->attendance_date);

            foreach ($request->attendance as $attendanceData) {
                $attendance = Attendance::updateOrCreate(
                    [
                        'student_id' => $attendanceData['student_id'],
                        'school_class_id' => $request->class_id,
                        'attendance_date' => $attendanceDate,
                        'period' => 'whole_day'
                    ],
                    [
                        'adviser_id' => $adviser->id,
                        'status' => $attendanceData['status'],
                        'time_in' => $attendanceData['time_in'] ?? null,
                        'time_out' => $attendanceData['time_out'] ?? null,
                        'remarks' => $attendanceData['remarks'] ?? null,
                        'academic_year' => '2025-2026'
                    ]
                );

                $savedCount++;
            }

            return response()->json([
                'success' => true,
                'message' => "Attendance saved successfully for {$savedCount} students!",
                'saved_count' => $savedCount,
                'date' => $attendanceDate->format('M d, Y')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving attendance: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show attendance reports
     */
    public function reports()
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['adviser', 'admin'])) {
            abort(403, 'Only advisers and administrators can view attendance reports.');
        }

        $user = Auth::user();
        
        if ($user->role === 'admin') {
            // Admin can see all classes
            $classes = SchoolClass::with(['students', 'adviser'])->where('is_active', true)->get();
        } else {
            // Adviser can see only their classes
            $classes = $user->advisedClasses()->with('students')->get();
        }

        return view('attendance.reports', compact('classes'));
    }

    /**
     * Get attendance data for reports (AJAX)
     */
    public function getAttendanceData(Request $request)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['adviser', 'admin'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'report_type' => 'required|in:daily,monthly,student_summary'
        ]);

        $user = Auth::user();
        $class = SchoolClass::find($request->class_id);

        // Verify user has access - admin can access all, adviser only their classes
        if ($user->role === 'adviser' && $class->adviser_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized access to class'], 403);
        }

        try {
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);

            switch ($request->report_type) {
                case 'daily':
                    return $this->getDailyReport($class->id, $startDate, $endDate);
                case 'monthly':
                    return $this->getMonthlyReport($class->id, $startDate, $endDate);
                case 'student_summary':
                    return $this->getStudentSummaryReport($class->id, $startDate, $endDate);
                default:
                    return response()->json(['error' => 'Invalid report type'], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error generating report: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get daily attendance report data
     */
    private function getDailyReport($classId, $startDate, $endDate)
    {
        $attendance = Attendance::with(['student'])
            ->forClass($classId)
            ->forDateRange($startDate, $endDate)
            ->orderBy('attendance_date')
            ->orderBy('student_id')
            ->get()
            ->groupBy('attendance_date');

        $dailyData = [];
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $dateStr = $currentDate->format('Y-m-d');
            $dayAttendance = $attendance->get($dateStr, collect());
            
            $dailyStats = [
                'date' => $currentDate->format('M d, Y'),
                'total' => $dayAttendance->count(),
                'present' => $dayAttendance->where('status', 'present')->count(),
                'absent' => $dayAttendance->where('status', 'absent')->count(),
                'late' => $dayAttendance->where('status', 'late')->count(),
                'excused' => $dayAttendance->where('status', 'excused')->count()
            ];

            $dailyData[] = $dailyStats;
            $currentDate->addDay();
        }

        return response()->json(['daily_data' => $dailyData]);
    }

    /**
     * Get monthly attendance summary
     */
    private function getMonthlyReport($classId, $startDate, $endDate)
    {
        $stats = Attendance::getAttendanceStatsForClass($classId, '2025-2026');
        
        return response()->json(['monthly_stats' => $stats]);
    }

    /**
     * Get student summary report
     */
    private function getStudentSummaryReport($classId, $startDate, $endDate)
    {
        $class = SchoolClass::with('students')->find($classId);
        $studentData = [];

        foreach ($class->students as $student) {
            $attendance = Attendance::forStudent($student->id)
                ->forDateRange($startDate, $endDate)
                ->get();

            $stats = [
                'student_name' => $student->first_name . ' ' . $student->last_name,
                'lrn' => $student->lrn,
                'total' => $attendance->count(),
                'present' => $attendance->where('status', 'present')->count(),
                'absent' => $attendance->where('status', 'absent')->count(),
                'late' => $attendance->where('status', 'late')->count(),
                'excused' => $attendance->where('status', 'excused')->count()
            ];

            $stats['attendance_rate'] = $stats['total'] > 0 ? 
                round(($stats['present'] / $stats['total']) * 100, 2) : 0;

            $studentData[] = $stats;
        }

        return response()->json(['student_data' => $studentData]);
    }
}