<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookIssue;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Grade 7 Books
        $grade7Books = [
            [
                'title' => 'Mathematics 7 Textbook',
                'book_code' => 'MTH-7-001',
                'subject' => 'Mathematics',
                'grade_level' => '7',
                'publisher' => 'DepEd Central Office',
                'isbn' => '978-971-0123-45-6',
                'publication_year' => 2024,
                'total_copies' => 50,
                'available_copies' => 48,
                'condition' => 'good',
                'description' => 'Standard Grade 7 Mathematics textbook aligned with K-12 curriculum',
                'is_active' => true,
            ],
            [
                'title' => 'English 7 Textbook',
                'book_code' => 'ENG-7-001',
                'subject' => 'English',
                'grade_level' => '7',
                'publisher' => 'DepEd Central Office',
                'isbn' => '978-971-0123-45-7',
                'publication_year' => 2024,
                'total_copies' => 50,
                'available_copies' => 49,
                'condition' => 'good',
                'description' => 'Standard Grade 7 English textbook for communication skills',
                'is_active' => true,
            ],
            [
                'title' => 'Science 7 Textbook',
                'book_code' => 'SCI-7-001',
                'subject' => 'Science',
                'grade_level' => '7',
                'publisher' => 'DepEd Central Office',
                'isbn' => '978-971-0123-45-8',
                'publication_year' => 2024,
                'total_copies' => 50,
                'available_copies' => 50,
                'condition' => 'new',
                'description' => 'Integrated Science textbook covering biology, chemistry, and physics',
                'is_active' => true,
            ],
            [
                'title' => 'Filipino 7 Textbook',
                'book_code' => 'FIL-7-001',
                'subject' => 'Filipino',
                'grade_level' => '7',
                'publisher' => 'DepEd Central Office',
                'isbn' => '978-971-0123-45-9',
                'publication_year' => 2024,
                'total_copies' => 50,
                'available_copies' => 47,
                'condition' => 'good',
                'description' => 'Wikang Filipino para sa Grade 7',
                'is_active' => true,
            ],
            [
                'title' => 'Araling Panlipunan 7',
                'book_code' => 'AP-7-001',
                'subject' => 'Araling Panlipunan',
                'grade_level' => '7',
                'publisher' => 'DepEd Central Office',
                'isbn' => '978-971-0123-46-0',
                'publication_year' => 2024,
                'total_copies' => 50,
                'available_copies' => 50,
                'condition' => 'new',
                'description' => 'Social Studies textbook covering Philippine history and culture',
                'is_active' => true,
            ],
            [
                'title' => 'MAPEH 7 Textbook',
                'book_code' => 'MAPEH-7-001',
                'subject' => 'MAPEH',
                'grade_level' => '7',
                'publisher' => 'DepEd Central Office',
                'isbn' => '978-971-0123-46-1',
                'publication_year' => 2024,
                'total_copies' => 50,
                'available_copies' => 49,
                'condition' => 'good',
                'description' => 'Music, Arts, Physical Education, and Health integrated textbook',
                'is_active' => true,
            ],
            [
                'title' => 'Edukasyon sa Pagpapakatao 7',
                'book_code' => 'ESP-7-001',
                'subject' => 'Edukasyon sa Pagpapakatao',
                'grade_level' => '7',
                'publisher' => 'DepEd Central Office',
                'isbn' => '978-971-0123-46-2',
                'publication_year' => 2024,
                'total_copies' => 50,
                'available_copies' => 50,
                'condition' => 'new',
                'description' => 'Values Education textbook for character development',
                'is_active' => true,
            ],
        ];

        foreach ($grade7Books as $bookData) {
            Book::create($bookData);
        }

        // Create some sample book issues
        $students = Student::where('is_active', true)->get();
        $books = Book::where('is_active', true)->get();
        $adviser = User::where('role', 'adviser')->first();
        $class = SchoolClass::first();

        if ($students->isNotEmpty() && $books->isNotEmpty() && $adviser && $class) {
            // Issue some books to students
            $issuesToCreate = [
                [
                    'book_id' => $books->where('book_code', 'MTH-7-001')->first()->id,
                    'student_id' => $students->first()->id,
                    'school_class_id' => $class->id,
                    'issued_by' => $adviser->id,
                    'issue_date' => Carbon::now()->subDays(30),
                    'expected_return_date' => Carbon::now()->addMonths(5),
                    'issue_condition' => 'good',
                    'status' => 'issued',
                    'issue_remarks' => 'Good condition when issued',
                    'academic_year' => '2025-2026',
                ],
                [
                    'book_id' => $books->where('book_code', 'ENG-7-001')->first()->id,
                    'student_id' => $students->first()->id,
                    'school_class_id' => $class->id,
                    'issued_by' => $adviser->id,
                    'issue_date' => Carbon::now()->subDays(25),
                    'expected_return_date' => Carbon::now()->addMonths(5),
                    'issue_condition' => 'good',
                    'status' => 'issued',
                    'issue_remarks' => 'Student is responsible',
                    'academic_year' => '2025-2026',
                ],
            ];

            if ($students->count() > 1) {
                $issuesToCreate[] = [
                    'book_id' => $books->where('book_code', 'FIL-7-001')->first()->id,
                    'student_id' => $students->skip(1)->first()->id,
                    'school_class_id' => $class->id,
                    'issued_by' => $adviser->id,
                    'issue_date' => Carbon::now()->subDays(20),
                    'expected_return_date' => Carbon::now()->addMonths(5),
                    'issue_condition' => 'good',
                    'status' => 'issued',
                    'issue_remarks' => 'Handle with care',
                    'academic_year' => '2025-2026',
                ];
                
                // Create a returned book example
                $issuesToCreate[] = [
                    'book_id' => $books->where('book_code', 'MAPEH-7-001')->first()->id,
                    'student_id' => $students->skip(1)->first()->id,
                    'school_class_id' => $class->id,
                    'issued_by' => $adviser->id,
                    'issue_date' => Carbon::now()->subDays(45),
                    'expected_return_date' => Carbon::now()->subDays(15),
                    'actual_return_date' => Carbon::now()->subDays(10),
                    'issue_condition' => 'good',
                    'return_condition' => 'fair',
                    'status' => 'returned',
                    'issue_remarks' => 'Good condition when issued',
                    'return_remarks' => 'Some pages were bent but readable',
                    'penalty_amount' => 0.00,
                    'penalty_paid' => false,
                    'academic_year' => '2025-2026',
                ];
            }

            foreach ($issuesToCreate as $issueData) {
                BookIssue::create($issueData);
            }
        }

        echo "Books and sample book issues seeded successfully!\n";
    }
}
