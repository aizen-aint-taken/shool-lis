@extends('layouts.app')

@section('content')
<!-- Role-based Access Control -->
@if(auth()->user()->role !== 'teacher')
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
    <strong>Access Denied:</strong> Only subject teachers can encode grades.
</div>
@else

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Individual Learners Quarterly Grade by Learning Area</h1>
    <p class="text-gray-600">Encode quarterly grades for individual students across all learning areas - Teacher: {{ auth()->user()->name }}</p>
</div>

<!-- Student Selection -->
<div class="bg-white rounded-lg shadow border border-gray-200 p-6 mb-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Select Student and Academic Year</h3>
    <form id="studentForm">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Class</label>
                <select id="classSelect" name="school_class_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Select Class</option>
                    @foreach($schoolClasses as $class)
                    <option value="{{ $class->id }}">Grade {{ $class->grade_level }} - {{ $class->section }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Student</label>
                <select id="studentSelect" name="student_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Select Student</option>
                    @foreach($students as $student)
                    <option value="{{ $student->id }}" data-class="{{ $student->school_class_id }}">{{ $student->last_name }}, {{ $student->first_name }} (LRN: {{ $student->lrn }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Academic Year</label>
                <select id="academicYearSelect" name="academic_year" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="2024-2025">2024-2025</option>
                    <option value="2025-2026" selected>2025-2026</option>
                    <option value="2026-2027">2026-2027</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="button" id="loadGradesBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg w-full">Load Student Grades</button>
            </div>
        </div>
    </form>
</div>

<!-- Quarterly Grade Encoding Table -->
<div id="gradesContainer" class="bg-white rounded-lg shadow border border-gray-200" style="display: none;">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">Individual Learners Quarterly Grade by Learning Area</h3>
        <div class="flex space-x-2">
            <button type="button" id="saveGradesBtn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">Save All Grades</button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Learning Area</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">1st Quarter</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">2nd Quarter</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">3rd Quarter</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">4th Quarter</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Final Grade</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                </tr>
            </thead>
            <tbody id="gradesTableBody" class="bg-white divide-y divide-gray-200">
                <!-- Dynamic content will be loaded here -->
            </tbody>
        </table>
    </div>
</div>

<!-- Success/Error Messages -->
<div id="messageContainer" class="mt-4" style="display: none;"></div>

@endif

<!-- Add CSRF token meta tag for AJAX requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
// Grade encoding JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    const loadGradesBtn = document.getElementById('loadGradesBtn');
    const saveGradesBtn = document.getElementById('saveGradesBtn');
    const gradesContainer = document.getElementById('gradesContainer');

    // Load student grades
    loadGradesBtn?.addEventListener('click', function() {
        const studentId = document.getElementById('studentSelect').value;
        const academicYear = document.getElementById('academicYearSelect').value;

        if (!studentId) {
            showMessage('Please select a student.', 'error');
            return;
        }

        loadStudentGrades(studentId, academicYear);
    });

    // Save grades
    saveGradesBtn?.addEventListener('click', function() {
        saveGrades();
    });

    function loadStudentGrades(studentId, academicYear) {
        // Get subjects from controller - same as admin view and other grade forms
        const subjects = @json($subjects);
        
        let tableHTML = '';
        subjects.forEach(subject => {
            tableHTML += `
            <tr class="hover:bg-gray-50" data-subject-id="${subject.id}">
                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">${subject.name}</td>
                <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                    <input type="number" class="grade-input w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           min="60" max="100" step="0.01" data-quarter="1st Quarter" placeholder="-">
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                    <input type="number" class="grade-input w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           min="60" max="100" step="0.01" data-quarter="2nd Quarter" placeholder="-">
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                    <input type="number" class="grade-input w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           min="60" max="100" step="0.01" data-quarter="3rd Quarter" placeholder="-">
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                    <input type="number" class="grade-input w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           min="60" max="100" step="0.01" data-quarter="4th Quarter" placeholder="-">
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                    <span class="final-grade text-sm font-medium text-gray-900">-</span>
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-center">
                    <span class="remarks-badge px-2 py-1 text-xs font-semibold rounded-full">-</span>
                </td>
            </tr>
        `;
        });
        });

        document.getElementById('gradesTableBody').innerHTML = tableHTML;
        gradesContainer.style.display = 'block';

        // Add event listeners for automatic calculation
        document.querySelectorAll('.grade-input').forEach(input => {
            input.addEventListener('input', calculateRowAverage);
        });
    }

    function calculateRowAverage(event) {
        const row = event.target.closest('tr');
        const inputs = row.querySelectorAll('.grade-input');
        const finalGradeSpan = row.querySelector('.final-grade');
        const remarksSpan = row.querySelector('.remarks-badge');

        let total = 0;
        let count = 0;

        inputs.forEach(input => {
            if (input.value && input.value !== '') {
                total += parseFloat(input.value);
                count++;
            }
        });

        if (count > 0) {
            const average = (total / count).toFixed(2);
            finalGradeSpan.textContent = average;

            const isPassed = average >= 75;
            remarksSpan.textContent = isPassed ? 'PASSED' : 'FAILED';
            remarksSpan.className = `remarks-badge px-2 py-1 text-xs font-semibold rounded-full ${
            isPassed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
        }`;
        }
    }

    function saveGrades() {
        const studentId = document.getElementById('studentSelect').value;
        const classId = document.getElementById('classSelect').value;
        const academicYear = document.getElementById('academicYearSelect').value;

        if (!studentId || !classId) {
            showMessage('Please select a student and class.', 'error');
            return;
        }

        const grades = [];
        document.querySelectorAll('#gradesTableBody tr').forEach(row => {
            const subjectId = row.getAttribute('data-subject-id');
            const inputs = row.querySelectorAll('.grade-input');

            inputs.forEach(input => {
                if (input.value && input.value !== '') {
                    grades.push({
                        subject_id: subjectId,
                        grading_period: input.getAttribute('data-quarter'),
                        score: parseFloat(input.value)
                    });
                }
            });
        });

        if (grades.length === 0) {
            showMessage('Please enter at least one grade.', 'error');
            return;
        }

        fetch('/grades/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    student_id: studentId,
                    school_class_id: classId,
                    academic_year: academicYear,
                    grades: grades
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(`Grades saved successfully! Encoded by: ${data.encoded_by}`, 'success');
                } else {
                    showMessage(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('Error saving grades.', 'error');
            });
    }

    function showMessage(message, type) {
        const alertClass = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
        document.getElementById('messageContainer').innerHTML = `
        <div class="${alertClass} px-4 py-3 rounded border">
            ${message}
        </div>
    `;
        document.getElementById('messageContainer').style.display = 'block';

        setTimeout(() => {
            document.getElementById('messageContainer').style.display = 'none';
        }, 5000);
    }
});
</script>

@endsection
