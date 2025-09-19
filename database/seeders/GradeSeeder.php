<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the students we created
        $ana = Student::where('lrn', '304866202500001')->first();
        $pedro = Student::where('lrn', '304866202500002')->first();
        
        // Get the teacher
        $teacher = User::where('role', 'teacher')->first();
        
        // Get subjects
        $subjects = Subject::all();
        
        // Get the class
        $class = $ana->schoolClass;
        
        if ($ana && $pedro && $teacher && $subjects->count() > 0 && $class) {
            // Create sample grades for Ana Rodriguez (student1)
            foreach ($subjects as $subject) {
                Grade::create([
                    'student_id' => $ana->id,
                    'subject_id' => $subject->id,
                    'school_class_id' => $class->id,
                    'teacher_id' => $teacher->id,
                    'grading_period' => '1st Quarter',
                    'score' => rand(75, 95),
                    'final_rating' => rand(75, 95),
                    'remarks' => rand(75, 95) >= 75 ? 'PASSED' : 'FAILED',
                    'academic_year' => '2025-2026'
                ]);
                
                Grade::create([
                    'student_id' => $ana->id,
                    'subject_id' => $subject->id,
                    'school_class_id' => $class->id,
                    'teacher_id' => $teacher->id,
                    'grading_period' => '2nd Quarter',
                    'score' => rand(75, 95),
                    'final_rating' => rand(75, 95),
                    'remarks' => rand(75, 95) >= 75 ? 'PASSED' : 'FAILED',
                    'academic_year' => '2025-2026'
                ]);
            }
            
            // Create sample grades for Pedro Garcia (student2)
            foreach ($subjects as $subject) {
                Grade::create([
                    'student_id' => $pedro->id,
                    'subject_id' => $subject->id,
                    'school_class_id' => $class->id,
                    'teacher_id' => $teacher->id,
                    'grading_period' => '1st Quarter',
                    'score' => rand(70, 90),
                    'final_rating' => rand(70, 90),
                    'remarks' => rand(70, 90) >= 75 ? 'PASSED' : 'FAILED',
                    'academic_year' => '2025-2026'
                ]);
            }
        }
    }
}