@extends('layouts.app')

@section('content')
<!-- Role-based Access Control -->
@if(auth()->user()->role === 'teacher')
@php $canEncode = true; @endphp
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
    <strong>Teacher Access:</strong> You can encode and modify grades for students.
</div>
@else
@php $canEncode = false; @endphp
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
    <strong>Access Denied:</strong> Only subject teachers can access grade encoding. Please use the grade viewing interface instead.
</div>
@endif

@if(auth()->user()->role === 'teacher')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Grade Encoding Portal - Teacher</h1>
    <p class="text-gray-600">Encode quarterly grades for students - Teacher: {{ auth()->user()->name }}</p>
    <div class="mt-2 text-sm text-blue-600">
        <p><strong>Instructions:</strong> Select a student and click "Load Student Grades" to view/edit their current grades. Use "Save All Grades" to persist your changes.</p>
    </div>
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
                <button type="button" id="loadGradesBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex-1">Load Student Grades</button>
                <button type="button" id="refreshGradesBtn" class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg" title="Refresh grades" style="display: none;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Quarterly Grade Encoding Table -->
<div id="gradesContainer" class="bg-white rounded-lg shadow border border-gray-200" style="display: none;">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">
            Grade Encoding for Selected Student
        </h3>
        <div class="flex space-x-2">
            <button type="button" id="saveGradesBtn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">Save All Grades</button>
            <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded text-xs">
                <span class="grade-status">Ready to encode</span>
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
    // Grade encoding JavaScript functionality
    document.addEventListener('DOMContentLoaded', function() {
        const loadGradesBtn = document.getElementById('loadGradesBtn');
        const saveGradesBtn = document.getElementById('saveGradesBtn');
        const refreshGradesBtn = document.getElementById('refreshGradesBtn');
        const gradesContainer = document.getElementById('gradesContainer');
        
        // Auto-load grades if student and class are already selected (after page refresh)
        const preSelectedStudent = document.getElementById('studentSelect').value;
        const preSelectedClass = document.getElementById('classSelect').value;
        const academicYear = document.getElementById('academicYearSelect').value;
        
        if (preSelectedStudent && preSelectedClass) {
            // Automatically load grades if student is already selected
            setTimeout(() => {
                loadStudentGrades(preSelectedStudent, academicYear);
                document.getElementById('refreshGradesBtn').style.display = 'block';
            }, 100);
        }

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
        
        // Refresh grades button - preserves unsaved inputs
        if (refreshGradesBtn) {
            refreshGradesBtn.addEventListener('click', function() {
                const studentId = document.getElementById('studentSelect').value;
                const academicYear = document.getElementById('academicYearSelect').value;
                
                if (studentId) {
                    console.log('Manual refresh of grades with input preservation...');
                    refreshGradesWithInputPreservation(studentId, academicYear);
                }
            });
        }

        // Save grades
        if (saveGradesBtn) {
            saveGradesBtn.addEventListener('click', function() {
                saveGrades();
            });
        }

        function loadStudentGrades(studentId, academicYear) {
            const subjects = @json($subjects);
            let tableHTML = '';

            subjects.forEach(subject => {
                // Always show input fields for teachers
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
                        <span class="remarks-badge px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">-</span>
                    </td>
                </tr>
            `;
            });

            document.getElementById('gradesTableBody').innerHTML = tableHTML;
            gradesContainer.style.display = 'block';

            // Load existing grades from database
            loadExistingGrades(studentId, academicYear);

            // Add event listeners for automatic calculation
            document.querySelectorAll('.grade-input').forEach(input => {
                input.addEventListener('input', function(e) {
                    calculateRowAverage(e);
                    updateGradeStatus();
                });
            });
            
            // Update status
            updateGradeStatus('Table loaded - ready for encoding');
        }

        function calculateRowAverage(event) {
            const row = event.target.closest('tr');
            const inputs = row.querySelectorAll('.grade-input');
            const finalGradeSpan = row.querySelector('.final-grade');
            const remarksSpan = row.querySelector('.remarks-badge');

            let total = 0;
            let count = 0;

            // Check input fields
            inputs.forEach(input => {
                if (input.value && input.value !== '') {
                    total += parseFloat(input.value);
                    count++;
                }
            });

            if (count > 0) {
                const average = (total / count).toFixed(2);
                finalGradeSpan.textContent = average;
                finalGradeSpan.style.fontWeight = 'bold';
                finalGradeSpan.style.color = average >= 75 ? '#059669' : '#DC2626';

                const isPassed = average >= 75;
                remarksSpan.textContent = isPassed ? 'PASSED' : 'FAILED';
                remarksSpan.className = `remarks-badge px-2 py-1 text-xs font-semibold rounded-full ${
                    isPassed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                }`;
            } else {
                finalGradeSpan.textContent = '-';
                finalGradeSpan.style.fontWeight = 'normal';
                finalGradeSpan.style.color = '#374151';
                remarksSpan.textContent = '-';
                remarksSpan.className = 'remarks-badge px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600';
            }
            
            // Calculate general average
            calculateGeneralAverage();
        }

        function saveGrades() {
            const studentId = document.getElementById('studentSelect').value;
            const schoolClassId = document.getElementById('classSelect').value;
            const academicYear = document.getElementById('academicYearSelect').value;

            if (!studentId || !schoolClassId) {
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

            // Show loading state
            const saveButton = document.getElementById('saveGradesBtn');
            if (saveButton) {
                saveButton.disabled = true;
                saveButton.textContent = 'Saving...';
                saveButton.classList.add('opacity-50');
            }
            
            updateGradeStatus('Saving grades...');

            fetch('/grades/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        student_id: studentId,
                        school_class_id: schoolClassId,
                        academic_year: academicYear,
                        grades: grades
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(`HTTP ${response.status}: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // Reset button state
                    const saveButton = document.getElementById('saveGradesBtn');
                    if (saveButton) {
                        saveButton.disabled = false;
                        saveButton.textContent = 'Save All Grades';
                        saveButton.classList.remove('opacity-50');
                    }
                    
                    if (data.success) {
                        showMessage(`✅ Grades saved successfully! Encoded by: ${data.encoded_by} (${data.updated_grades} grades saved)`, 'success');
                        updateGradeStatus(`Saved successfully (${data.updated_grades} grades)`);
                        
                        // Mark inputs as saved with visual feedback
                        document.querySelectorAll('.grade-input').forEach(input => {
                            if (input.value && input.value !== '') {
                                input.style.backgroundColor = '#D1FAE5'; // Light green
                                input.style.borderColor = '#10B981'; // Green border
                            }
                        });
                        
                        // Automatically refresh to show persistence after a short delay
                        setTimeout(() => {
                            const currentStudentId = document.getElementById('studentSelect').value;
                            const currentAcademicYear = document.getElementById('academicYearSelect').value;
                            if (currentStudentId && currentAcademicYear) {
                                loadExistingGrades(currentStudentId, currentAcademicYear);
                            }
                        }, 1000);
                    } else {
                        showMessage('❌ Error: ' + (data.message || 'Failed to save grades'), 'error');
                        updateGradeStatus('Save failed');
                    }
                })
                .catch(error => {
                    // Reset button state on error
                    const saveButton = document.getElementById('saveGradesBtn');
                    if (saveButton) {
                        saveButton.disabled = false;
                        saveButton.textContent = 'Save All Grades';
                        saveButton.classList.remove('opacity-50');
                    }
                    
                    console.error('Error saving grades:', error);
                    showMessage('❌ Error saving grades: ' + error.message, 'error');
                    updateGradeStatus('Save error');
                });
        }

        function loadExistingGrades(studentId, academicYear) {
            fetch(`/grades/student/${studentId}?academic_year=${academicYear}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Loaded existing grades:', data);
                    if (data && typeof data === 'object') {
                        // Clear saved styling first
                        document.querySelectorAll('.grade-input').forEach(input => {
                            input.style.backgroundColor = '';
                            input.style.borderColor = '';
                        });
                        
                        // Populate existing grades
                        Object.keys(data).forEach(subjectName => {
                            const subjectGrades = data[subjectName];
                            const subjectRow = Array.from(document.querySelectorAll('#gradesTableBody tr')).find(row => {
                                return row.querySelector('td').textContent.trim() === subjectName;
                            });

                            if (subjectRow) {
                                Object.keys(subjectGrades).forEach(quarter => {
                                    const gradeArray = subjectGrades[quarter];
                                    if (gradeArray && gradeArray.length > 0) {
                                        const grade = gradeArray[0]; // Get first grade for this quarter
                                        const input = subjectRow.querySelector(`input[data-quarter="${quarter}"]`);
                                        if (input) {
                                            input.value = grade.score;
                                            // Style saved grades with green background
                                            input.style.backgroundColor = '#D1FAE5';
                                            input.style.borderColor = '#10B981';
                                        }
                                    }
                                });
                                
                                // Calculate final grade for this row
                                const firstInput = subjectRow.querySelector('.grade-input');
                                if (firstInput) {
                                    calculateRowAverage({ target: firstInput });
                                }
                            }
                        });
                        
                        // Calculate general average after loading all grades
                        calculateGeneralAverage();
                        updateGradeStatus('Grades loaded from database');
                    } else {
                        updateGradeStatus('No existing grades found');
                    }
                })
                .catch(error => {
                    console.error('Error loading existing grades:', error);
                    updateGradeStatus('Error loading grades');
                    // Don't show error to user for missing grades - it's normal for new students
                });
        }
        
        function refreshGradesWithInputPreservation(studentId, academicYear) {
            // Preserve current input values
            const currentInputs = {};
            document.querySelectorAll('.grade-input').forEach(input => {
                const row = input.closest('tr');
                const subjectId = row.getAttribute('data-subject-id');
                const quarter = input.getAttribute('data-quarter');
                const key = `${subjectId}-${quarter}`;
                if (input.value && input.value !== '') {
                    currentInputs[key] = input.value;
                }
            });
            
            updateGradeStatus('Refreshing grades...');
            
            // Load fresh data from database but preserve unsaved inputs
            fetch(`/grades/student/${studentId}?academic_year=${academicYear}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    // First populate from database
                    if (data && typeof data === 'object') {
                        Object.keys(data).forEach(subjectName => {
                            const subjectGrades = data[subjectName];
                            const subjectRow = Array.from(document.querySelectorAll('#gradesTableBody tr')).find(row => {
                                return row.querySelector('td').textContent.trim() === subjectName;
                            });

                            if (subjectRow) {
                                Object.keys(subjectGrades).forEach(quarter => {
                                    const gradeArray = subjectGrades[quarter];
                                    if (gradeArray && gradeArray.length > 0) {
                                        const grade = gradeArray[0];
                                        const input = subjectRow.querySelector(`input[data-quarter="${quarter}"]`);
                                        if (input) {
                                            const subjectId = subjectRow.getAttribute('data-subject-id');
                                            const key = `${subjectId}-${quarter}`;
                                            
                                            // Only update if no unsaved input exists
                                            if (!currentInputs[key]) {
                                                input.value = grade.score;
                                                input.style.backgroundColor = '#D1FAE5';
                                                input.style.borderColor = '#10B981';
                                            }
                                        }
                                    }
                                });
                            }
                        });
                    }
                    
                    // Then restore preserved inputs (these take priority)
                    Object.keys(currentInputs).forEach(key => {
                        const [subjectId, quarter] = key.split('-');
                        const subjectRow = document.querySelector(`tr[data-subject-id="${subjectId}"]`);
                        if (subjectRow) {
                            const input = subjectRow.querySelector(`input[data-quarter="${quarter}"]`);
                            if (input) {
                                input.value = currentInputs[key];
                                // Style unsaved inputs with yellow background
                                input.style.backgroundColor = '#FEF3C7';
                                input.style.borderColor = '#F59E0B';
                            }
                        }
                    });
                    
                    // Recalculate all averages
                    document.querySelectorAll('#gradesTableBody tr').forEach(row => {
                        const firstInput = row.querySelector('.grade-input');
                        if (firstInput) {
                            calculateRowAverage({ target: firstInput });
                        }
                    });
                    
                    calculateGeneralAverage();
                    updateGradeStatus('Refreshed - unsaved changes preserved');
                })
                .catch(error => {
                    console.error('Error refreshing grades:', error);
                    updateGradeStatus('Refresh error');
                });
        }
        
        function calculateGeneralAverage() {
            const finalGrades = [];
            document.querySelectorAll('#gradesTableBody .final-grade').forEach(span => {
                if (span.textContent && span.textContent !== '-') {
                    finalGrades.push(parseFloat(span.textContent));
                }
            });
            
            const avgElement = document.getElementById('generalAverage');
            if (finalGrades.length > 0) {
                const generalAvg = (finalGrades.reduce((a, b) => a + b) / finalGrades.length).toFixed(2);
                avgElement.textContent = generalAvg;
                avgElement.style.color = generalAvg >= 75 ? '#059669' : '#DC2626';
            } else {
                avgElement.textContent = '-';
                avgElement.style.color = '#2563EB';
            }
        }
        
        function updateGradeStatus(message = 'Ready') {
            const statusElement = document.querySelector('.grade-status');
            if (statusElement) {
                statusElement.textContent = message;
            }
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
