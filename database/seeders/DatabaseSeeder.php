<?php

namespace Database\Seeders;

use App\Models\User;
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
            'username' => 'student1',
            'email' => 'ana.rodriguez@student.maharlika.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);



        User::create([
            'name' => 'Pedro Garcia',
            'username' => 'student2',
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
    }
}
