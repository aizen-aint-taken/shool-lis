<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show dashboard with dynamic stats
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get enrollment stats based on user role
        if ($user->role === 'admin') {
            $enrollmentStats = $this->getAdminEnrollmentStats();
        } elseif ($user->role === 'adviser') {
            $enrollmentStats = $this->getAdviserEnrollmentStats($user);
        } else {
            $enrollmentStats = $this->getBasicEnrollmentStats();
        }
        
        // Get grade level breakdown
        $gradeLevelStats = $this->getGradeLevelStats($user);
        
        // Get recent activities (simplified for now)
        $recentActivities = $this->getRecentActivities($user);
        
        return view('dashboard.index', compact(
            'enrollmentStats',
            'gradeLevelStats',
            'recentActivities'
        ));
    }
    
    /**
     * Get enrollment stats for admin users
     */
    private function getAdminEnrollmentStats()
    {
        $total = Student::where('is_active', true)->count();
        $maleCount = Student::where('is_active', true)->where('gender', 'Male')->count();
        $femaleCount = Student::where('is_active', true)->where('gender', 'Female')->count();
        
        return [
            'total' => $total,
            'male' => $maleCount,
            'female' => $femaleCount
        ];
    }
    
    /**
     * Get enrollment stats for adviser users (their classes only)
     */
    private function getAdviserEnrollmentStats($user)
    {
        $classIds = $user->advisedClasses()->where('is_active', true)->pluck('id');
        
        $total = Student::whereIn('school_class_id', $classIds)->where('is_active', true)->count();
        $maleCount = Student::whereIn('school_class_id', $classIds)
            ->where('is_active', true)
            ->where('gender', 'Male')
            ->count();
        $femaleCount = Student::whereIn('school_class_id', $classIds)
            ->where('is_active', true)
            ->where('gender', 'Female')
            ->count();
        
        return [
            'total' => $total,
            'male' => $maleCount,
            'female' => $femaleCount
        ];
    }
    
    /**
     * Get basic enrollment stats for other users
     */
    private function getBasicEnrollmentStats()
    {
        return [
            'total' => 0,
            'male' => 0,
            'female' => 0
        ];
    }
    
    /**
     * Get grade level breakdown stats
     */
    private function getGradeLevelStats($user)
    {
        $gradeLevels = ['7', '8', '9', '10', '11', '12'];
        $stats = [];
        
        foreach ($gradeLevels as $level) {
            if ($user->role === 'admin') {
                // Admin sees all students
                $query = Student::whereHas('schoolClass', function($q) use ($level) {
                    $q->where('grade_level', $level)->where('is_active', true);
                })->where('is_active', true);
            } elseif ($user->role === 'adviser') {
                // Adviser sees only their advised classes
                $classIds = $user->advisedClasses()->where('is_active', true)->pluck('id');
                $query = Student::whereIn('school_class_id', $classIds)
                    ->whereHas('schoolClass', function($q) use ($level) {
                        $q->where('grade_level', $level);
                    })
                    ->where('is_active', true);
            } else {
                $query = Student::whereRaw('1 = 0'); // No results for other roles
            }
            
            $male = $query->clone()->where('gender', 'Male')->count();
            $female = $query->clone()->where('gender', 'Female')->count();
            $total = $male + $female;
            
            $stats["G{$level}"] = [
                'male' => $male,
                'female' => $female,
                'total' => $total
            ];
        }
        
        return $stats;
    }
    
    /**
     * Get recent activities (placeholder implementation)
     */
    private function getRecentActivities($user)
    {
        // This would typically fetch from an activities/audit log table
        // For now, return some sample data
        return [
            [
                'type' => 'grade_update',
                'message' => 'Mathematics grades updated',
                'time' => '2 hours ago',
                'color' => 'green'
            ],
            [
                'type' => 'enrollment',
                'message' => 'New student enrolled',
                'time' => '1 day ago',
                'color' => 'blue'
            ],
            [
                'type' => 'form_generation',
                'message' => 'SF9 forms generated for Q1',
                'time' => '3 days ago',
                'color' => 'yellow'
            ]
        ];
    }
}