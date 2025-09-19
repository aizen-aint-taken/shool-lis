<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Administrator',
            'username' => 'admin1',
            'email' => 'admin@maharlika.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);


        User::create([
            'name' => 'Maria Santos',
            'username' => 'adviser1',
            'email' => 'maria.santos@maharlika.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'adviser',
        ]);

        User::create([
            'name' => 'Juan Dela Cruz',
            'username' => 'adviser2',
            'email' => 'juan.delacruz@maharlika.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'adviser',
        ]);


        User::create([
            'name' => 'Ana Rodriguez',
            'username' => '304866202500001', // Using LRN as username
            'email' => 'ana.rodriguez@student.maharlika.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);



        User::create([
            'name' => 'Pedro Garcia',
            'username' => '304866202500002', // Using LRN as username
            'email' => 'pedro.garcia@student.maharlika.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        // Create 1 Subject Teacher
        User::create([
            'name' => 'Teacher Mathematics',
            'username' => 'teacher1',
            'email' => 'teacher.math@maharlika.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        // Create Subjects
        $subjects = [
            ['name' => 'Filipino', 'description' => 'Filipino Language', 'grade_level' => '7', 'is_active' => true],
            ['name' => 'English', 'description' => 'English Language', 'grade_level' => '7', 'is_active' => true],
            ['name' => 'Mathematics', 'description' => 'Mathematics', 'grade_level' => '7', 'is_active' => true],
            ['name' => 'Araling Panlipunan', 'description' => 'Social Studies', 'grade_level' => '7', 'is_active' => true],
            ['name' => 'Edukasyon sa Pagpapakatao', 'description' => 'Values Education', 'grade_level' => '7', 'is_active' => true],
            ['name' => 'MAPEH', 'description' => 'Music, Arts, Physical Education, and Health', 'grade_level' => '7', 'is_active' => true],
            ['name' => 'Science', 'description' => 'Science', 'grade_level' => '7', 'is_active' => true],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }

        // Create School Classes
        SchoolClass::create([
            'class_name' => 'Grade 7 - Section A',
            'grade_level' => '7',
            'section' => 'A',
            'school_year' => '2025-2026',
            'adviser_id' => 2, // Maria Santos
            'max_students' => 45,
            'is_active' => true,
        ]);

        // Create Students
        Student::create([
            'lrn' => '304866202500001',
            'first_name' => 'Ana',
            'last_name' => 'Rodriguez',
            'middle_name' => 'Cruz',
            'birth_date' => '2010-05-15',
            'gender' => 'Female',
            'address' => '123 Main Street, Manila',
            'contact_number' => '09123456789',
            'parent_guardian' => 'Carmen Rodriguez',
            'parent_contact' => '09987654321',
            'school_class_id' => 1,
            'student_type' => 'Regular',
            'mother_tongue' => 'Tagalog',
            'religion' => 'Catholic',
            'ethnic_group' => 'Filipino',
            'is_active' => true,
        ]);

        Student::create([
            'lrn' => '304866202500002',
            'first_name' => 'Pedro',
            'last_name' => 'Garcia',
            'middle_name' => 'Santos',
            'birth_date' => '2010-08-22',
            'gender' => 'Male',
            'address' => '456 Rizal Avenue, Quezon City',
            'contact_number' => '09111222333',
            'parent_guardian' => 'Roberto Garcia Sr.',
            'parent_contact' => '09444555666',
            'school_class_id' => 1,
            'student_type' => 'Regular',
            'mother_tongue' => 'Tagalog',
            'religion' => 'Catholic',
            'ethnic_group' => 'Filipino',
            'is_active' => true,
        ]);
        
        // Seed Books and Book Issues
        $this->call(BookSeeder::class);
        
        // Seed Grades
        $this->call(GradeSeeder::class);
    }
}