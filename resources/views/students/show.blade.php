
541ues46.png
odcmw0dj.png
if i click view or edit it is access denied why? please solve this@extends('layouts.app')

@section('title', 'Student Details')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    
    <!-- Role Access Check -->
    @if(auth()->user()->role === 'admin')
    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6">
        <strong>Administrator Access:</strong> You have full access to student information.
    </div>
    @elseif(auth()->user()->role === 'adviser')
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
        <strong>Adviser Access:</strong> You can view and manage student details.
    </div>
    @else
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <strong>Access Denied:</strong> Only administrators and advisers can view student details.
    </div>
    @endif

    @if(in_array(auth()->user()->role, ['admin', 'adviser']))
    
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Student Details</h1>
                <p class="text-gray-600">Complete information for {{ $student->full_name }}</p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ auth()->user()->role === "admin" ? route('admin.students.index') : route('students.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Students
                </a>
                <a href="{{ auth()->user()->role === "admin" ? route('admin.students.edit', $student) : route('students.edit', $student) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Student
                </a>
            </div>
        </div>
    </div>

    <!-- Student Information Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Learner Reference Number (LRN)</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $student->lrn }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $student->full_name }}</dd>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Birth Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($student->birth_date)->format('F j, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Age</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($student->birth_date)->age }} years old</dd>
                        </div>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Gender</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $student->gender }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Student Type</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $student->student_type }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            @if($student->is_active)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Cultural Information -->
        <div class="bg-white rounded-lg shadow border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Cultural Information</h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Mother Tongue</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $student->mother_tongue ?: 'Not specified' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Religion</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $student->religion ?: 'Not specified' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Ethnic Group</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $student->ethnic_group ?: 'Not specified' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="bg-white rounded-lg shadow border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Contact Information</h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Address</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $student->address }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Student Contact</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $student->contact_number ?: 'Not provided' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Parent/Guardian</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $student->parent_guardian }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Parent Contact</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $student->parent_contact ?: 'Not provided' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Class Information -->
        <div class="bg-white rounded-lg shadow border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Class Information</h3>
            </div>
            <div class="p-6">
                @if($student->schoolClass)
                <dl class="grid grid-cols-1 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Class</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <a href="{{ auth()->user()->role === "admin" ? route('admin.classes.show', $student->schoolClass) : route('classes.show', $student->schoolClass) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                {{ $student->schoolClass->class_name }}
                            </a>
                        </dd>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Grade Level</dt>
                            <dd class="mt-1 text-sm text-gray-900">Grade {{ $student->schoolClass->grade_level }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Section</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $student->schoolClass->section }}</dd>
                        </div>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">School Year</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $student->schoolClass->school_year }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Class Adviser</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $student->schoolClass->adviser->name }}</dd>
                    </div>
                </dl>
                @else
                <p class="text-gray-500 text-sm">Not assigned to any class.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Grades Section (if available) -->
    @if($student->grades && $student->grades->count() > 0)
    <div class="mt-6">
        <div class="bg-white rounded-lg shadow border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Grades Overview</h3>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">1st Quarter</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">2nd Quarter</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">3rd Quarter</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">4th Quarter</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Final Grade</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($student->grades->groupBy('subject.name') as $subjectName => $subjectGrades)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $subjectName }}
                                </td>
                                @for($quarter = 1; $quarter <= 4; $quarter++)
                                    @php
                                        $grade = $subjectGrades->where('quarter', $quarter)->first();
                                    @endphp
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $grade ? number_format($grade->grade, 0) : '-' }}
                                    </td>
                                @endfor
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    @php
                                        $finalGrade = $subjectGrades->where('quarter', 'Final')->first();
                                    @endphp
                                    {{ $finalGrade ? number_format($finalGrade->grade, 0) : '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Enrollment History / Transfer Options -->
    <div class="mt-6">
        <div class="bg-white rounded-lg shadow border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Administrative Actions</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center space-x-4">
                    @if($student->schoolClass)
                    <button type="button" onclick="showTransferModal()" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                        Transfer to Another Class
                    </button>
                    @endif
                    
                    @if(auth()->user()->role === 'admin')
                    <button type="button" onclick="toggleStudentStatus({{ $student->id }}, '{{ $student->full_name }}', {{ $student->is_active ? 'true' : 'false' }})" 
                            class="bg-{{ $student->is_active ? 'red' : 'green' }}-600 hover:bg-{{ $student->is_active ? 'red' : 'green' }}-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $student->is_active ? 'Deactivate' : 'Activate' }} Student
                    </button>
                    @endif
                </div>
                
                <div class="mt-4 text-sm text-gray-600">
                    <p><strong>Last Updated:</strong> {{ $student->updated_at->format('F j, Y g:i A') }}</p>
                    <p><strong>Enrolled:</strong> {{ $student->created_at->format('F j, Y g:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    @endif
</div>

<!-- Transfer Modal -->
<div id="transferModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Transfer Student</h3>
            <form id="transferForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Transfer to Class:</label>
                    <select id="transferClassId" name="new_class_id" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="">Select a class...</option>
                        <!-- Will be populated by JavaScript -->
                    </select>
                </div>
                <div class="flex justify-center space-x-4">
                    <button type="button" onclick="hideTransferModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded text-sm">Cancel</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">Transfer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Transfer functionality
function showTransferModal() {
    // Load available classes
    fetch('/classes/api')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('transferClassId');
            select.innerHTML = '<option value="">Select a class...</option>';
            
            data.forEach(classData => {
                if (classData.id !== {{ $student->school_class_id ?? 'null' }}) {
                    select.innerHTML += `<option value="${classData.id}">${classData.class_name}</option>`;
                }
            });
        });
    
    document.getElementById('transferModal').classList.remove('hidden');
}

function hideTransferModal() {
    document.getElementById('transferModal').classList.add('hidden');
}

// Handle transfer form submission
document.getElementById('transferForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const classId = document.getElementById('transferClassId').value;
    if (!classId) {
        alert('Please select a class to transfer to.');
        return;
    }
    
    fetch(`/students/{{ $student->id }}/transfer`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            new_class_id: classId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message || 'Transfer failed.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred during transfer.');
    });
});

// Toggle student status
function toggleStudentStatus(studentId, studentName, isActive) {
    const action = isActive ? 'deactivate' : 'activate';
    
    if (confirm(`Are you sure you want to ${action} ${studentName}?`)) {
        fetch(`/students/${studentId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert(data.message || 'Operation failed.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred.');
        });
    }
}
</script>
@endsection