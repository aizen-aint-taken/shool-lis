@extends('layouts.app')

@section('content')
<!-- Role-based Access Control -->
@if(auth()->user()->role === 'admin')
<div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6">
    <strong>Administrator View:</strong> You can view all grades but cannot encode them. Only subject teachers can encode grades.
</div>
@elseif(auth()->user()->role === 'adviser')
<div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
    <strong>Adviser View:</strong> You can view grades for your advised classes but cannot encode them.
</div>
@else
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
    <strong>Access Denied:</strong> You do not have permission to access this page.
</div>
@endif

@if(in_array(auth()->user()->role, ['admin', 'adviser']))

<div class="mb-6">
    @if(auth()->user()->role === 'admin')
    <h1 class="text-2xl font-bold text-gray-900">Grade Viewing Portal - Administrator</h1>
    <p class="text-gray-600">View grades encoded by teachers - Administrator: {{ auth()->user()->name }}</p>
    <div class="mt-2 text-sm text-blue-600">
        <p><strong>Instructions:</strong> Select a class and student below to view their encoded grades. Refresh the page or click refresh button to see the latest updates.</p>
    </div>
    @elseif(auth()->user()->role === 'adviser')
    <h1 class="text-2xl font-bold text-gray-900">Grade Viewing Portal - Adviser</h1>
    <p class="text-gray-600">View grades for your advised classes - Adviser: {{ auth()->user()->name }}</p>
    <div class="mt-2 text-sm text-blue-600">
        <p><strong>Instructions:</strong> Select a class and student below to view their encoded grades. Refresh the page or click refresh button to see the latest updates.</p>
    </div>
    @endif
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
                    <option value="{{ $class->id }}" {{ $selectedClass && $selectedClass->id == $class->id ? 'selected' : '' }}>
                        Grade {{ $class->grade_level }} - {{ $class->section }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Student</label>
                <select id="studentSelect" name="student_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Select Student</option>
                    @foreach($students as $student)
                    <option value="{{ $student->id }}" data-class="{{ $student->school_class_id }}">
                        {{ $student->last_name }}, {{ $student->first_name }} (LRN: {{ $student->lrn }})
                    </option>
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
            <div class="flex items-end space-x-2">
                <button type="button" id="loadGradesBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex-1">View Student Grades</button>
                <button type="button" id="refreshGradesBtn" class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg" title="Refresh grades" style="display: none;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Quarterly Grade Viewing Table -->
<div id="gradesContainer" class="bg-white rounded-lg shadow border border-gray-200" style="display: none;">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">
            Grade Viewing for Selected Student
        </h3>
        <div class="flex space-x-2">
            <span class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm">
                @if(auth()->user()->role === 'admin')
                Administrator View Only - Teachers Encode
                @else
                View Only - No Encoding Access
                @endif
            </span>
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

<div class="mt-6 bg-white rounded-lg shadow border border-gray-200 p-6">
    <div class="text-center">
        <div class="text-lg font-medium text-gray-900 mb-2">General Average</div>
        <div class="text-3xl font-bold text-blue-600" id="generalAverage">-</div>
    </div>
</div>

<!-- Success/Error Messages -->
<div id="messageContainer" class="mt-4" style="display: none;"></div>

@endif

<!-- Add CSRF token meta tag for AJAX requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">



<script>
    // Grade viewing JavaScript functionality
    document.addEventListener('DOMContentLoaded', function() {
        const loadGradesBtn = document.getElementById('loadGradesBtn');
        const gradesContainer = document.getElementById('gradesContainer');
        
        // Load student grades
        loadGradesBtn.addEventListener('click', function() {
            const studentId = document.getElementById('studentSelect').value;
            const academicYear = document.getElementById('academicYearSelect').value;

            if (!studentId) {
                showMessage('Please select a student.', 'error');
                return;
            }

            loadStudentGrades(studentId, academicYear);
            
            // Show refresh button after first load
            document.getElementById('refreshGradesBtn').style.display = 'block';
        });
        
        // Refresh grades button
        document.getElementById('refreshGradesBtn').addEventListener('click', function() {
            const studentId = document.getElementById('studentSelect').value;
            const academicYear = document.getElementById('academicYearSelect').value;
            
            if (studentId) {
                console.log('Manual refresh of grades...');
                // Clear current data first for clean refresh
                document.querySelectorAll('#gradesTableBody .grade-display').forEach(span => {
                    span.textContent = '-';
                    span.style.fontWeight = 'normal';
                    span.style.color = '#374151';
                });
                
                document.querySelectorAll('#gradesTableBody .final-grade').forEach(span => {
                    span.textContent = '-';
                    span.style.fontWeight = 'normal';
                });
                
                document.querySelectorAll('#gradesTableBody .remarks-badge').forEach(span => {
                    span.textContent = '-';
                    span.className = 'remarks-badge px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600';
                });
                
                // Reset general average
                const avgElement = document.getElementById('generalAverage');
                if (avgElement) {
                    avgElement.textContent = '-';
                    avgElement.style.color = '#2563EB';
                }
                
                // Force refresh from database
                loadExistingGrades(studentId, academicYear);
            }
        });

        function loadStudentGrades(studentId, academicYear) {
            const subjects = @json($subjects);
            let tableHTML = '';

            subjects.forEach(subject => {
                // For view-only - show read-only spans
                tableHTML += `
                <tr class="hover:bg-gray-50" data-subject-id="${subject.id}">
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">${subject.name}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <span class="grade-display text-sm text-gray-700" data-quarter="1st Quarter">-</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <span class="grade-display text-sm text-gray-700" data-quarter="2nd Quarter">-</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <span class="grade-display text-sm text-gray-700" data-quarter="3rd Quarter">-</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <span class="grade-display text-sm text-gray-700" data-quarter="4th Quarter">-</span>
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

            document.getElementById('gradesTableBody').innerHTML = tableHTML;
            gradesContainer.style.display = 'block';

            // Load existing grades from database
            loadExistingGrades(studentId, academicYear);
        }

        function loadExistingGrades(studentId, academicYear) {
            console.log('Loading grades for student:', studentId, 'academic year:', academicYear);
            console.log('Current user role:', @json(auth()->user()->role));
            console.log('CSRF token:', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
            fetch(`/grades/student/${studentId}?academic_year=${academicYear}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', Object.fromEntries(response.headers));
                    
                    if (!response.ok) {
                        return response.text().then(text => {
                            console.error('Error response body:', text);
                            throw new Error(`HTTP error! status: ${response.status}, body: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Raw API response:', data);
                    console.log('Data type:', typeof data, 'Keys:', Object.keys(data || {}));
                    console.log('User role:', @json(auth()->user()->role));
                    
                    if (data && typeof data === 'object' && Object.keys(data).length > 0) {
                        let totalScore = 0;
                        let subjectCount = 0;
                        
                        // Clear all existing grade displays first for clean refresh
                        document.querySelectorAll('#gradesTableBody .grade-display').forEach(span => {
                            span.textContent = '-';
                            span.style.fontWeight = 'normal';
                            span.style.color = '#374151';
                        });
                        
                        // Reset final grades and remarks
                        document.querySelectorAll('#gradesTableBody .final-grade').forEach(span => {
                            span.textContent = '-';
                            span.style.fontWeight = 'normal';
                        });
                        
                        document.querySelectorAll('#gradesTableBody .remarks-badge').forEach(span => {
                            span.textContent = '-';
                            span.className = 'remarks-badge px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600';
                        });
                        
                        // Populate existing grades
                        Object.keys(data).forEach(subjectName => {
                            console.log('Processing subject:', subjectName);
                            const subjectGrades = data[subjectName];
                            const subjectRow = Array.from(document.querySelectorAll('#gradesTableBody tr')).find(row => {
                                return row.querySelector('td').textContent.trim() === subjectName;
                            });

                            if (subjectRow) {
                                console.log('Found row for subject:', subjectName);
                                let quarterTotal = 0;
                                let quarterCount = 0;
                                
                                // Handle both array and object structures
                                Object.keys(subjectGrades).forEach(quarter => {
                                    console.log('Processing quarter:', quarter, 'data:', subjectGrades[quarter]);
                                    const gradeData = subjectGrades[quarter];
                                    let grade = null;
                                    
                                    // Handle different data structures
                                    if (Array.isArray(gradeData) && gradeData.length > 0) {
                                        grade = gradeData[0]; // Get first grade for this quarter
                                    } else if (gradeData && typeof gradeData === 'object') {
                                        grade = gradeData;
                                    }
                                    
                                    if (grade && grade.score) {
                                        console.log('Setting grade:', grade.score, 'for quarter:', quarter);
                                        const span = subjectRow.querySelector(`span[data-quarter="${quarter}"]`);
                                        if (span) {
                                            span.textContent = grade.score;
                                            span.style.fontWeight = 'bold';
                                            span.style.color = grade.score >= 75 ? '#059669' : '#DC2626';
                                            quarterTotal += parseFloat(grade.score);
                                            quarterCount++;
                                        } else {
                                            console.log('Could not find span for quarter:', quarter);
                                        }
                                    }
                                });
                                
                                // Calculate final grade for this subject
                                if (quarterCount > 0) {
                                    const average = (quarterTotal / quarterCount).toFixed(2);
                                    console.log('Calculated average for', subjectName, ':', average);
                                    const finalGradeSpan = subjectRow.querySelector('.final-grade');
                                    const remarksSpan = subjectRow.querySelector('.remarks-badge');
                                    
                                    if (finalGradeSpan) {
                                        finalGradeSpan.textContent = average;
                                        finalGradeSpan.style.fontWeight = 'bold';
                                        finalGradeSpan.style.color = average >= 75 ? '#059669' : '#DC2626';
                                    }
                                    
                                    if (remarksSpan) {
                                        const isPassed = average >= 75;
                                        remarksSpan.textContent = isPassed ? 'PASSED' : 'FAILED';
                                        remarksSpan.className = `remarks-badge px-2 py-1 text-xs font-semibold rounded-full ${
                                            isPassed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                                        }`;
                                    }
                                    
                                    totalScore += parseFloat(average);
                                    subjectCount++;
                                } else {
                                    console.log('No quarters found for subject:', subjectName);
                                }
                            } else {
                                console.log('Could not find row for subject:', subjectName);
                            }
                        });
                        
                        // Calculate and display general average with visual styling
                        if (subjectCount > 0) {
                            const generalAverage = (totalScore / subjectCount).toFixed(2);
                            console.log('General average calculated:', generalAverage);
                            const avgElement = document.getElementById('generalAverage');
                            if (avgElement) {
                                avgElement.textContent = generalAverage;
                                avgElement.style.color = generalAverage >= 75 ? '#059669' : '#DC2626';
                                avgElement.style.fontWeight = 'bold';
                            }
                            showMessage(`Successfully loaded grades for ${subjectCount} subjects (GWA: ${generalAverage})`, 'success');
                        } else {
                            console.log('No subjects with grades found');
                            // Reset general average
                            const avgElement = document.getElementById('generalAverage');
                            if (avgElement) {
                                avgElement.textContent = '-';
                                avgElement.style.color = '#2563EB';
                                avgElement.style.fontWeight = 'bold';
                            }
                        }
                    } else {
                        console.log('No grades found for this student - empty response or no data');
                        showMessage('No grades found for this student in the selected academic year. Grades will appear here when teachers encode them.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error loading existing grades:', error);
                    showMessage(`Unable to load grades: ${error.message}. Please try refreshing the page.`, 'error');
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