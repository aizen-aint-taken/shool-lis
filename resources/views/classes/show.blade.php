@extends('layouts.app')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-2 text-sm text-gray-600 mb-2">
                <a href="{{ route('classes.index') }}" class="hover:text-blue-600">List of Classes</a>
                <span>/</span>
                <span class="text-gray-900">{{ $class->class_name }}</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $class->class_name }}</h1>
            <p class="text-gray-600">Grade {{ $class->grade_level }} - {{ $class->section }} • SY {{ $class->school_year }}</p>
        </div>
        <div class="flex items-center space-x-4">
            @auth
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'adviser')
                <a href="{{ route('students.create') }}?class_id={{ $class->id }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Enroll Student
                </a>
                <a href="{{ route('classes.edit', $class) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium">
                    Edit Class
                </a>
                @endif
            @endauth
        </div>
    </div>
</div>

<!-- Class Information Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">Enrolled Students</h2>
                <p class="text-2xl font-bold text-gray-900">{{ $enrollmentStats['total_enrolled'] }}</p>
                <p class="text-sm text-gray-600">of {{ $enrollmentStats['capacity'] }} max capacity</p>
                @if($enrollmentStats['available_slots'] > 0)
                    <p class="text-xs text-green-600">{{ $enrollmentStats['available_slots'] }} slots available</p>
                @else
                    <p class="text-xs text-red-600">Class is full</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">Class Adviser</h2>
                @if($class->adviser)
                    <p class="text-lg font-bold text-gray-900">{{ $class->adviser->name }}</p>
                    <p class="text-sm text-gray-600">ID: {{ $class->adviser->id }}</p>
                @else
                    <p class="text-lg font-medium text-gray-500">No Adviser Assigned</p>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('classes.edit', $class) }}" class="text-sm text-blue-600 hover:text-blue-800">Assign Adviser</a>
                    @endif
                @endif
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">Gender Distribution</h2>
                <div class="flex space-x-4 mt-1">
                    <div>
                        <p class="text-lg font-bold text-blue-600">{{ $enrollmentStats['male_count'] }}</p>
                        <p class="text-xs text-gray-600">Male</p>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-pink-600">{{ $enrollmentStats['female_count'] }}</p>
                        <p class="text-xs text-gray-600">Female</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Navigation Tabs -->
<div class="bg-white rounded-lg shadow border border-gray-200 mb-6">
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8 px-6">
            <button class="py-4 px-1 border-b-2 border-blue-600 font-medium text-sm text-blue-600" id="students-tab">
                Students List
            </button>
            <button class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700" id="grades-tab">
                Grades
            </button>
            <button class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700" id="reports-tab">
                Reports
            </button>
        </nav>
    </div>
</div>

<!-- Students List -->
<div class="bg-white rounded-lg shadow border border-gray-200" id="students-content">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">Enrolled Students</h3>
            <div class="flex items-center space-x-4">
                <input type="text" placeholder="Search students..." class="border border-gray-300 rounded-md px-3 py-2 text-sm w-64" id="search-students">
                <select class="border border-gray-300 rounded-md px-3 py-2 text-sm" id="filter-gender">
                    <option value="">All Students</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">LRN</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Enrolled</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="students-table-body">
                @if($class->students->count() > 0)
                    @foreach($class->students->where('is_active', true) as $student)
                    <tr class="hover:bg-gray-50 student-row" data-gender="{{ $student->gender }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $student->lrn }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <div class="h-8 w-8 rounded-full {{ $student->gender === 'Male' ? 'bg-blue-100' : 'bg-pink-100' }} flex items-center justify-center">
                                        <span class="text-xs font-medium {{ $student->gender === 'Male' ? 'text-blue-600' : 'text-pink-600' }}">
                                            {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 student-name">{{ $student->first_name }} {{ $student->last_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $student->is_active ? 'Active Student' : 'Inactive' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->gender }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($student->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Enrolled
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('students.show', $student) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                @auth
                                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'adviser')
                                    <a href="{{ route('students.edit', $student) }}" class="text-green-600 hover:text-green-900">Edit</a>
                                    @endif
                                @endauth
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <div class="py-4">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No students enrolled</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by enrolling students to this class.</p>
                                <div class="mt-6">
                                    <a href="{{ route('students.create') }}?class_id={{ $class->id }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Enroll Student
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('search-students');
    const filterSelect = document.getElementById('filter-gender');
    const studentRows = document.querySelectorAll('.student-row');

    function filterStudents() {
        const searchTerm = searchInput.value.toLowerCase();
        const genderFilter = filterSelect.value;

        studentRows.forEach(row => {
            const studentName = row.querySelector('.student-name').textContent.toLowerCase();
            const studentGender = row.dataset.gender;
            
            const matchesSearch = studentName.includes(searchTerm);
            const matchesGender = !genderFilter || studentGender === genderFilter;
            
            if (matchesSearch && matchesGender) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterStudents);
    filterSelect.addEventListener('change', filterStudents);

    // Tab functionality
    const tabs = {
        'students-tab': 'students-content',
        'grades-tab': 'grades-content',
        'reports-tab': 'reports-content'
    };

    Object.keys(tabs).forEach(tabId => {
        const tab = document.getElementById(tabId);
        if (tab) {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs
                Object.keys(tabs).forEach(t => {
                    const tabElement = document.getElementById(t);
                    if (tabElement) {
                        tabElement.className = 'py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700';
                    }
                });
                
                // Add active class to clicked tab
                this.className = 'py-4 px-1 border-b-2 border-blue-600 font-medium text-sm text-blue-600';
                
                // Show/hide content based on tab
                if (tabId === 'grades-tab') {
                    window.location.href = '{{ route("grades.view.only.class", $class) }}';
                } else if (tabId === 'reports-tab') {
                    window.location.href = '{{ route("sf.sf5") }}?class_id={{ $class->id }}';
                }
            });
        }
    });
});
</script>

@endsection