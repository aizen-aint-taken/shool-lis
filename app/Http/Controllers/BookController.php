<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookIssue;
use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

/**
 * Book Management Controller
 * 
 * Handles book distribution and tracking for advisers.
 * Supports dynamic SF3 form generation with real book data.
 * 
 * @author Laravel LIS System
 * @version 1.0
 */
class BookController extends Controller
{
    /**
     * Display book management dashboard.
     */
    public function index()
    {
        // Only advisers and admins can access book management
        if (!Auth::user()->isAdviser() && !Auth::user()->isAdmin()) {
            abort(403, 'You do not have permission to access book management.');
        }

        $user = Auth::user();
        $stats = [];
        
        if ($user->isAdviser()) {
            // For advisers, show stats for their assigned classes only
            $advisedClasses = $user->advisedClasses()->where('is_active', true)->get();
            $classIds = $advisedClasses->pluck('id');
            
            $stats = [
                'total_books_issued' => BookIssue::whereIn('school_class_id', $classIds)->count(),
                'currently_issued' => BookIssue::whereIn('school_class_id', $classIds)->where('status', 'issued')->count(),
                'returned_books' => BookIssue::whereIn('school_class_id', $classIds)->where('status', 'returned')->count(),
                'lost_damaged' => BookIssue::whereIn('school_class_id', $classIds)->whereIn('status', ['lost', 'damaged'])->count(),
                'overdue_books' => BookIssue::whereIn('school_class_id', $classIds)
                    ->where('status', 'issued')
                    ->where('expected_return_date', '<', Carbon::now())
                    ->count(),
            ];
        } else {
            // For admins, show global stats
            $stats = [
                'total_books_issued' => BookIssue::count(),
                'currently_issued' => BookIssue::where('status', 'issued')->count(),
                'returned_books' => BookIssue::where('status', 'returned')->count(),
                'lost_damaged' => BookIssue::whereIn('status', ['lost', 'damaged'])->count(),
                'overdue_books' => BookIssue::where('status', 'issued')
                    ->where('expected_return_date', '<', Carbon::now())
                    ->count(),
            ];
        }

        return view('books.index', compact('stats'));
    }

    /**
     * Show book issue form.
     */
    public function issueForm(Request $request)
    {
        if (!Auth::user()->isAdviser() && !Auth::user()->isAdmin()) {
            abort(403, 'You do not have permission to issue books.');
        }

        $user = Auth::user();
        $selectedClassId = $request->get('class_id');
        
        // Get classes - for advisers, only their assigned classes
        $classesQuery = SchoolClass::with(['adviser'])->where('is_active', true);
        if ($user->isAdviser()) {
            $classesQuery->where('adviser_id', $user->id);
        }
        $classes = $classesQuery->orderBy('grade_level')->orderBy('section')->get();

        $selectedClass = null;
        $students = collect();
        $availableBooks = collect();
        
        if ($selectedClassId) {
            $selectedClass = SchoolClass::with(['adviser', 'students' => function ($query) {
                $query->where('is_active', true)->orderBy('last_name')->orderBy('first_name');
            }])->find($selectedClassId);
            
            if ($selectedClass) {
                // Verify adviser access
                if ($user->isAdviser() && $selectedClass->adviser_id !== $user->id) {
                    abort(403, 'You can only issue books to students in your assigned classes.');
                }
                
                $students = $selectedClass->students;
                
                // Get available books for this grade level
                $availableBooks = Book::active()
                    ->forGrade($selectedClass->grade_level)
                    ->where('available_copies', '>', 0)
                    ->orderBy('subject')
                    ->orderBy('title')
                    ->get();
            }
        }

        return view('books.issue', compact('classes', 'selectedClass', 'students', 'availableBooks'));
    }

    /**
     * Issue a book to a student.
     */
    public function issueBook(Request $request)
    {
        if (!Auth::user()->isAdviser() && !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'student_id' => 'required|exists:students,id',
            'issue_condition' => 'required|in:new,good,fair,poor',
            'expected_return_date' => 'nullable|date|after:today',
            'issue_remarks' => 'nullable|string|max:500',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $book = Book::findOrFail($validated['book_id']);
                $student = Student::findOrFail($validated['student_id']);
                
                // Verify adviser access to student's class
                if (Auth::user()->isAdviser() && $student->schoolClass->adviser_id !== Auth::id()) {
                    throw new \Exception('You can only issue books to students in your assigned classes.');
                }
                
                // Check if book is available
                if (!$book->isAvailable()) {
                    throw new \Exception('This book is not available for issue.');
                }
                
                // Check if student already has this book
                $existingIssue = BookIssue::where('book_id', $book->id)
                    ->where('student_id', $student->id)
                    ->where('status', 'issued')
                    ->first();
                    
                if ($existingIssue) {
                    throw new \Exception('This student already has this book issued.');
                }
                
                // Create book issue record
                BookIssue::create([
                    'book_id' => $book->id,
                    'student_id' => $student->id,
                    'school_class_id' => $student->school_class_id,
                    'issued_by' => Auth::id(),
                    'issue_date' => Carbon::now(),
                    'expected_return_date' => $validated['expected_return_date'] ?? Carbon::now()->addMonths(6),
                    'issue_condition' => $validated['issue_condition'],
                    'status' => 'issued',
                    'issue_remarks' => $validated['issue_remarks'],
                    'academic_year' => $student->schoolClass->school_year,
                ]);
                
                // Update book availability
                $book->decrementAvailableCopies();
                
                Log::info('Book issued successfully', [
                    'book_id' => $book->id,
                    'student_id' => $student->id,
                    'issued_by' => Auth::id(),
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Book issued successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Book issue failed', [
                'error' => $e->getMessage(),
                'book_id' => $validated['book_id'] ?? null,
                'student_id' => $validated['student_id'] ?? null,
            ]);
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Show book return form.
     */
    public function returnForm(Request $request)
    {
        if (!Auth::user()->isAdviser() && !Auth::user()->isAdmin()) {
            abort(403, 'You do not have permission to process book returns.');
        }

        $user = Auth::user();
        $selectedClassId = $request->get('class_id');
        
        // Get classes - for advisers, only their assigned classes
        $classesQuery = SchoolClass::with(['adviser'])->where('is_active', true);
        if ($user->isAdviser()) {
            $classesQuery->where('adviser_id', $user->id);
        }
        $classes = $classesQuery->orderBy('grade_level')->orderBy('section')->get();

        $selectedClass = null;
        $issuedBooks = collect();
        
        if ($selectedClassId) {
            $selectedClass = SchoolClass::find($selectedClassId);
            
            if ($selectedClass) {
                // Verify adviser access
                if ($user->isAdviser() && $selectedClass->adviser_id !== $user->id) {
                    abort(403, 'You can only process returns for your assigned classes.');
                }
                
                // Get currently issued books for this class
                $issuedBooks = BookIssue::with(['book', 'student'])
                    ->where('school_class_id', $selectedClassId)
                    ->where('status', 'issued')
                    ->orderBy('issue_date')
                    ->get();
            }
        }

        return view('books.return', compact('classes', 'selectedClass', 'issuedBooks'));
    }

    /**
     * Process book return.
     */
    public function returnBook(Request $request)
    {
        if (!Auth::user()->isAdviser() && !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'book_issue_id' => 'required|exists:book_issues,id',
            'return_condition' => 'required|in:new,good,fair,poor,damaged,lost',
            'return_remarks' => 'nullable|string|max:500',
        ]);

        try {
            $bookIssue = BookIssue::with(['book', 'student.schoolClass'])->findOrFail($validated['book_issue_id']);
            
            // Verify adviser access
            if (Auth::user()->isAdviser() && $bookIssue->student->schoolClass->adviser_id !== Auth::id()) {
                throw new \Exception('You can only process returns for your assigned classes.');
            }
            
            if ($bookIssue->status !== 'issued') {
                throw new \Exception('This book has already been processed.');
            }
            
            // Determine status based on condition
            $status = 'returned';
            if ($validated['return_condition'] === 'lost') {
                $status = 'lost';
            } elseif ($validated['return_condition'] === 'damaged') {
                $status = 'damaged';
            }
            
            // Mark book as returned/lost/damaged
            if ($status === 'returned') {
                $bookIssue->markAsReturned($validated['return_condition'], $validated['return_remarks']);
            } else {
                $bookIssue->markAsLostOrDamaged($status, $validated['return_remarks']);
            }
            
            Log::info('Book return processed successfully', [
                'book_issue_id' => $bookIssue->id,
                'status' => $status,
                'processed_by' => Auth::id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Book return processed successfully!',
                'penalty' => $bookIssue->penalty_amount
            ]);

        } catch (\Exception $e) {
            Log::error('Book return failed', [
                'error' => $e->getMessage(),
                'book_issue_id' => $validated['book_issue_id'] ?? null,
            ]);
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
