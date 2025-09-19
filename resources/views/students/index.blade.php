@extends('layouts.app')

@section('content')
<!-- Role-based Access Control -->
@if(auth()->user()->role === 'admin')
<div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6">
    <strong>Administrator Access:</strong> You can manage all students across all classes.
</div>
@elseif(auth()->user()->role === 'adviser')
<div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
    <strong>Adviser Access:</strong> You can manage students and their enrollments.
</div>
@else
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
    <strong>Access Denied:</strong> Only administrators and advisers can manage students.
</div>
@endif

@if(in_array(auth()->user()->role, ['admin', 'adviser']))

<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Student Management</h1>
            <p class="text-gray-600">Manage student enrollments and information - {{ auth()->user()->role === "admin" ? 'Administrator' : 'Adviser' }}: {{ auth()->user()->name }}</p>
        </div>
        <div class="flex items-center space-x-4">
            <!-- Use admin-specific route for admins -->
            <a href="{{ auth()->user()->role === "admin" ? route('admin.students.create') : route('students.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Enroll New Student
            </a>
            <!-- Use appropriate class management route -->
            <a href="{{ auth()->user()->role === "admin" ? route('admin.classes.index') : route('classes.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Manage Classes
            </a>
        </div>
    </div>
</div>

<!-- Filter and Search -->
<div class="bg-white rounded-lg shadow border border-gray-200 mb-6">
    <div class="p-4">
        <form method="GET" action="{{ auth()->user()->role === "admin" ? route('admin.students.index') : route('students.index') }}" id="filterForm">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Class</label>
                    <select name="class_id" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm" onchange="document.getElementById('filterForm').submit()">
                        <option value="">All Classes</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                            Grade {{ $class->grade_level }} - {{ $class->section }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Grade Level</label>
                    <select name="grade_level" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm" onchange="document.getElementById('filterForm').submit()">
                        <option value="">All Grades</option>
                        @foreach($gradeLevels as $level)
                        <option value="{{ $level }}" {{ request('grade_level') == $level ? 'selected' : '' }}>
                            Grade {{ $level }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                    <select name="gender" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm" onchange="document.getElementById('filterForm').submit()">
                        <option value="">All Genders</option>
                        <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or LRN..." class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm mr-2">Filter</button>
                    <a href="{{ auth()->user()->role === "admin" ? route('admin.students.index') : route('students.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg text-sm">Clear</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Students Table -->
<div class="bg-white rounded-lg shadow border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">Enrolled Students</h3>
            <div class="text-sm text-gray-600">
                Showing {{ $students->count() }} of {{ $students->total() }} students
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Information</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact Info</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($students as $student)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full {{ $student->gender === 'Male' ? 'bg-blue-100' : 'bg-pink-100' }} flex items-center justify-center">
                                    <span class="text-sm font-medium {{ $student->gender === 'Male' ? 'text-blue-600' : 'text-pink-600' }}">
                                        {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $student->full_name }}</div>
                                <div class="text-sm text-gray-500">LRN: {{ $student->lrn }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($student->schoolClass)
                        <div class="text-sm text-gray-900">Grade {{ $student->schoolClass->grade_level }} - {{ $student->schoolClass->section }}</div>
                        <div class="text-sm text-gray-500">{{ $student->schoolClass->school_year }}</div>
                        @else
                        <div class="text-sm text-gray-500 italic">No class assigned</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $student->parent_guardian }}</div>
                        <div class="text-sm text-gray-500">{{ $student->parent_contact }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($student->is_active)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                        @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ auth()->user()->role === "admin" ? route('students.show', $student) : route('students.show', $student) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-2 py-1 rounded text-xs">
                                View
                            </a>
                            <a href="{{ auth()->user()->role === "admin" ? route('admin.students.edit', $student) : route('students.edit', $student) }}" class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-2 py-1 rounded text-xs">
                                Edit
                            </a>
                            @if(auth()->user()->role === 'admin')
                            <button type="button" onclick="deleteStudent({{ $student->id }}, '{{ $student->full_name }}')" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-2 py-1 rounded text-xs">
                                Remove
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center py-8">
                            <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <p class="text-lg font-medium text-gray-400">No students found</p>
                            <p class="text-sm text-gray-400 mb-4">Enroll your first student to get started</p>
                            <a href="{{ auth()->user()->role === "admin" ? route('admin.students.create') : route('students.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                Enroll New Student
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($students->hasPages())
    <div class="px-6 py-3 border-t border-gray-200">
        {{ $students->links() }}
    </div>
    @endif
</div>

<!-- Success/Error Messages -->
<div id="messageContainer" class="mt-4" style="display: none;"></div>

@endif

<!-- Add CSRF token meta tag for AJAX requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
// Delete student functionality
function deleteStudent(studentId, studentName) {
    // Use appropriate route based on user role
    const deleteUrl = '{{ auth()->user()->role === 'admin' ? '/admin/students/' : '/students/' }}' + studentId;
    
    if (confirm(`Are you sure you want to remove ${studentName} from the system? This action cannot be undone.`)) {
        fetch(deleteUrl, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('✅ Student removed successfully!', 'success');
                // Reload the page after successful deletion
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                showMessage('❌ Error: ' + (data.message || 'Failed to remove student'), 'error');
            }
        })
        .catch(error => {
            console.error('Error removing student:', error);
            showMessage('❌ Error removing student: ' + error.message, 'error');
        });
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
</script>

@endsection