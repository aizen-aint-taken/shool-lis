@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Daily Attendance Encoding</h1>
                    <p class="text-gray-600">Mark student attendance for your assigned classes</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/attendance" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                        Back to Attendance
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Class and Date Selection -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Select Class and Date</h3>
            <form id="classDateForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Class</label>
                    <select id="classSelect" name="class_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Select a class</option>
                        @foreach($advisedClasses as $class)
                        <option value="{{ $class->id }}" {{ $selectedClass && $selectedClass->id == $class->id ? 'selected' : '' }}>
                            {{ $class->class_name }} ({{ $class->students->count() }} students)
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Attendance Date</label>
                    <input type="date" 
                           id="attendanceDate" 
                           name="attendance_date" 
                           value="{{ $attendanceDate }}"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Load Students
                    </button>
                </div>
            </form>
        </div>

        @if($selectedClass && $students->count() > 0)
        <!-- Attendance Form -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">{{ $selectedClass->class_name }}</h3>
                    <p class="text-sm text-gray-600">{{ Carbon\Carbon::parse($attendanceDate)->format('l, F d, Y') }} - {{ $students->count() }} students</p>
                </div>
                <div class="flex space-x-2">
                    <button type="button" id="markAllPresent" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                        Mark All Present
                    </button>
                    <button type="button" id="saveAttendance" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                        Save Attendance
                    </button>
                </div>
            </div>
            
            <form id="attendanceForm" class="p-6">
                @csrf
                <input type="hidden" name="class_id" value="{{ $selectedClass->id }}">
                <input type="hidden" name="attendance_date" value="{{ $attendanceDate }}">
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Time In</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Time Out</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($students as $index => $student)
                            @php
                                $existing = $existingAttendance[$student->id] ?? null;
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $student->last_name }}, {{ $student->first_name }}
                                            @if($student->middle_name)
                                                {{ $student->middle_name }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-500">LRN: {{ $student->lrn }}</div>
                                    <input type="hidden" name="attendance[{{ $index }}][student_id]" value="{{ $student->id }}">
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <select name="attendance[{{ $index }}][status]" 
                                            class="status-select border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            data-student-id="{{ $student->id }}">
                                        <option value="present" {{ $existing && $existing->status === 'present' ? 'selected' : '' }}>Present</option>
                                        <option value="absent" {{ $existing && $existing->status === 'absent' ? 'selected' : '' }}>Absent</option>
                                        <option value="late" {{ $existing && $existing->status === 'late' ? 'selected' : '' }}>Late</option>
                                        <option value="excused" {{ $existing && $existing->status === 'excused' ? 'selected' : '' }}>Excused</option>
                                    </select>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <input type="time" 
                                           name="attendance[{{ $index }}][time_in]" 
                                           class="time-input border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           value="{{ $existing ? $existing->getFormattedTimeIn() : '' }}"
                                           data-student-id="{{ $student->id }}">
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <input type="time" 
                                           name="attendance[{{ $index }}][time_out]" 
                                           class="time-input border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           value="{{ $existing ? $existing->getFormattedTimeOut() : '' }}"
                                           data-student-id="{{ $student->id }}">
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="text" 
                                           name="attendance[{{ $index }}][remarks]" 
                                           class="w-full border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Optional remarks"
                                           value="{{ $existing ? $existing->remarks : '' }}"
                                           data-student-id="{{ $student->id }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Save Button -->
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="window.history.back()" class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Save Attendance
                    </button>
                </div>
            </form>
        </div>
        @elseif($selectedClass && $students->count() === 0)
        <!-- No Students -->
        <div class="bg-white shadow rounded-lg p-8 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Students Enrolled</h3>
            <p class="text-gray-600">This class doesn't have any students enrolled yet. Please add students to the class first.</p>
            <div class="mt-4">
                <a href="/students/create?class={{ $selectedClass->id }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Add Students to Class
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Success/Error Messages -->
<div id="messageContainer" class="fixed top-4 right-4 z-50" style="display: none;"></div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle class and date form submission
    document.getElementById('classDateForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const classId = document.getElementById('classSelect').value;
        const date = document.getElementById('attendanceDate').value;
        
        if (!classId || !date) {
            showMessage('Please select both class and date.', 'error');
            return;
        }
        
        window.location.href = `/attendance/daily/${classId}?date=${date}`;
    });
    
    // Handle mark all present
    document.getElementById('markAllPresent')?.addEventListener('click', function() {
        const statusSelects = document.querySelectorAll('.status-select');
        const timeInputs = document.querySelectorAll('.time-input');
        
        statusSelects.forEach(select => {
            select.value = 'present';
        });
        
        // Set default time in to 7:00 AM
        timeInputs.forEach(input => {
            if (input.name.includes('time_in')) {
                input.value = '07:00';
            }
        });
        
        showMessage('All students marked as present!', 'success');
    });
    
    // Handle attendance form submission
    document.getElementById('attendanceForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const saveBtn = document.getElementById('saveAttendance');
        saveBtn.disabled = true;
        saveBtn.textContent = 'Saving...';
        
        const formData = new FormData(this);
        const data = {};
        
        // Convert FormData to object
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }
        
        // Group attendance data
        const attendance = [];
        const attendanceData = {};
        
        // Parse attendance data
        Object.keys(data).forEach(key => {
            if (key.startsWith('attendance[')) {
                const match = key.match(/attendance\[(\d+)\]\[(.+)\]/);
                if (match) {
                    const index = match[1];
                    const field = match[2];
                    
                    if (!attendanceData[index]) {
                        attendanceData[index] = {};
                    }
                    attendanceData[index][field] = data[key];
                }
            }
        });
        
        // Convert to array format
        Object.values(attendanceData).forEach(item => {
            attendance.push(item);
        });
        
        const requestData = {
            class_id: data.class_id,
            attendance_date: data.attendance_date,
            attendance: attendance
        };
        
        fetch('/attendance/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage(`✅ ${data.message}`, 'success');
                
                // Add visual feedback to saved items
                document.querySelectorAll('tbody tr').forEach(row => {
                    row.style.backgroundColor = '#F0FDF4'; // Light green
                    setTimeout(() => {
                        row.style.backgroundColor = '';
                    }, 2000);
                });
            } else {
                showMessage(`❌ ${data.message}`, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('❌ Error saving attendance. Please try again.', 'error');
        })
        .finally(() => {
            saveBtn.disabled = false;
            saveBtn.textContent = 'Save Attendance';
        });
    });
    
    // Handle status change - auto set time
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            const studentId = this.dataset.studentId;
            const status = this.value;
            const timeInInput = document.querySelector(`input[name*="time_in"][data-student-id="${studentId}"]`);
            const timeOutInput = document.querySelector(`input[name*="time_out"][data-student-id="${studentId}"]`);
            
            if (status === 'present') {
                if (!timeInInput.value) timeInInput.value = '07:00';
                if (!timeOutInput.value) timeOutInput.value = '17:00';
            } else if (status === 'late') {
                if (!timeInInput.value) timeInInput.value = '07:30';
                if (!timeOutInput.value) timeOutInput.value = '17:00';
            } else if (status === 'absent') {
                timeInInput.value = '';
                timeOutInput.value = '';
            }
        });
    });
    
    function showMessage(message, type) {
        const alertClass = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
        document.getElementById('messageContainer').innerHTML = `
            <div class="${alertClass} px-4 py-3 rounded border shadow-lg">
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