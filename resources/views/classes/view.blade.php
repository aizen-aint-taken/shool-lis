@extends('layouts.app')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-2 text-sm text-gray-600 mb-2">
                <a href="{{ url('/classes') }}" class="hover:text-blue-600">List of Classes</a>
                <span>/</span>
                <span class="text-gray-900">Grade 7 - Section A</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Grade 7 - Section A</h1>
            <p class="text-gray-600">Morning Session • SY 2025-2026</p>
        </div>
        <div class="flex items-center space-x-4">
            @auth
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'adviser')
                <button onclick="openEnrollModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Enroll Student
                </button>
                <a href="{{ url('/classes/1/edit') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium">
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
                <p class="text-2xl font-bold text-gray-900">42</p>
                <p class="text-sm text-gray-600">of 45 max capacity</p>
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
                <p class="text-lg font-bold text-gray-900">Maria Santos</p>
                <p class="text-sm text-gray-600">ID: 304866001</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9m-4 4h.01M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">Attendance Rate</h2>
                <p class="text-2xl font-bold text-gray-900">96%</p>
                <p class="text-sm text-gray-600">This month</p>
            </div>
        </div>
    </div>
</div>

<!-- Navigation Tabs -->
<div class="bg-white rounded-lg shadow border border-gray-200 mb-6">
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8 px-6">
            <button class="py-4 px-1 border-b-2 border-blue-600 font-medium text-sm text-blue-600">
                Students List
            </button>
            <button class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700">
                Attendance
            </button>
            <button class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700">
                Grades
            </button>
            <button class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700">
                Reports
            </button>
        </nav>
    </div>
</div>

<!-- Students List -->
<div class="bg-white rounded-lg shadow border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">Enrolled Students</h3>
            <div class="flex items-center space-x-4">
                <input type="text" placeholder="Search students..." class="border border-gray-300 rounded-md px-3 py-2 text-sm w-64">
                <select class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                    <option>All Students</option>
                    <option>Male</option>
                    <option>Female</option>
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
            <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        304866202500001
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8">
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-xs font-medium text-blue-600">JD</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">Juan Dela Cruz</div>
                                <div class="text-sm text-gray-500">Active Student</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Male</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Aug 15, 2025</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Enrolled
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ url('/students/304866202500001') }}" class="text-blue-600 hover:text-blue-900">View</a>
                            @auth
                                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'adviser')
                                <a href="{{ url('/students/304866202500001/edit') }}" class="text-green-600 hover:text-green-900">Edit</a>
                                <button onclick="removeStudent('304866202500001')" class="text-red-600 hover:text-red-900">Remove</button>
                                @endif
                            @endauth
                        </div>
                    </td>
                </tr>
                
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        304866202500002
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8">
                                <div class="h-8 w-8 rounded-full bg-pink-100 flex items-center justify-center">
                                    <span class="text-xs font-medium text-pink-600">MS</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">Maria Santos</div>
                                <div class="text-sm text-gray-500">Active Student</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Female</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Aug 15, 2025</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Enrolled
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ url('/students/304866202500002') }}" class="text-blue-600 hover:text-blue-900">View</a>
                            @auth
                                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'adviser')
                                <a href="{{ url('/students/304866202500002/edit') }}" class="text-green-600 hover:text-green-900">Edit</a>
                                <button onclick="removeStudent('304866202500002')" class="text-red-600 hover:text-red-900">Remove</button>
                                @endif
                            @endauth
                        </div>
                    </td>
                </tr>
                
                <!-- Additional student rows would go here -->
                
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Showing 1 to 42 of 42 students
            </div>
            <div class="flex space-x-2">
                <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-500" disabled>Previous</button>
                <button class="px-3 py-1 bg-blue-600 text-white rounded text-sm">1</button>
                <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-500" disabled>Next</button>
            </div>
        </div>
    </div>
</div>

<!-- Enroll Student Modal -->
<div id="enrollModal" class="fixed inset-0 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            Enroll Student to Grade 7 - Section A
                        </h3>
                        
                        <form id="enrollForm" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Search Student by LRN or Name</label>
                                <input type="text" id="studentSearch" placeholder="Enter LRN or student name..." class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                            </div>
                            
                            <div id="studentResults" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Select Student</label>
                                <div class="border border-gray-300 rounded-md max-h-40 overflow-y-auto">
                                    <!-- Student search results will appear here -->
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Enrollment Date</label>
                                <input type="date" id="enrollmentDate" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm" value="{{ date('Y-m-d') }}">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Remarks (Optional)</label>
                                <textarea id="enrollmentRemarks" placeholder="Any additional notes..." class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm" rows="3"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button onclick="confirmEnrollment()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                    Enroll Student
                </button>
                <button onclick="closeEnrollModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function openEnrollModal() {
    document.getElementById('enrollModal').classList.remove('hidden');
}

function closeEnrollModal() {
    document.getElementById('enrollModal').classList.add('hidden');
}

function confirmEnrollment() {
    // Add enrollment logic here
    alert('Student enrolled successfully!');
    closeEnrollModal();
}

function removeStudent(lrn) {
    if (confirm('Are you sure you want to remove this student from the class?')) {
        // Add remove logic here
        alert('Student removed from class.');
    }
}
</script>
@endsection