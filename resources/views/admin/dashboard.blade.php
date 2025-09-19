@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Administrator Dashboard</h1>
                    <p class="text-gray-600">DepEd LIS - System Administration</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500">Welcome, {{ auth()->user()->name }}</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Administrator
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <!-- Total Users -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $totalUsers }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Advisers -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Advisers</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $totalAdvisers }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Teachers -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.75 2.524z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Teachers</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $totalTeachers }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Students -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Students</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $totalStudents }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Classes -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Classes</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $totalClasses }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- User Management -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">User Management</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <a href="/admin/advisers/create" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center justify-center transition duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Create New Adviser
                        </a>
                        <a href="/admin/users" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg inline-flex items-center justify-center transition duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                            </svg>
                            Manage All Users
                        </a>
                    </div>
                </div>
            </div>

            <!-- System Management -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">System Management</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <a href="/admin/classes" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg inline-flex items-center justify-center transition duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Manage Classes
                        </a>
                        <a href="{{ auth()->user()->role === 'admin' ? '/admin/students' : '/students' }}" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg inline-flex items-center justify-center transition duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                            </svg>
                            Manage Students
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- School Forms & Reports -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- School Forms -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">School Forms</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <a href="/sf/sf1" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded text-sm inline-flex items-center justify-center transition duration-150">
                            SF1 - School Register
                        </a>
                        <a href="/sf/sf2" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded text-sm inline-flex items-center justify-center transition duration-150">
                            SF2 - Daily Attendance
                        </a>
                        <a href="/sf/sf3" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded text-sm inline-flex items-center justify-center transition duration-150">
                            SF3 - Books Monitoring
                        </a>
                        <a href="/sf/sf5" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded text-sm inline-flex items-center justify-center transition duration-150">
                            SF5 - Promotion Report
                        </a>
                    </div>
                </div>
            </div>

            <!-- Grade Management -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Grade Management</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <a href="/grades/view-only" class="w-full bg-orange-600 hover:bg-orange-700 text-white px-3 py-2 rounded text-sm inline-flex items-center justify-center transition duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            View All Grades
                        </a>
                        <a href="/sf/sf9" class="w-full bg-orange-600 hover:bg-orange-700 text-white px-3 py-2 rounded text-sm inline-flex items-center justify-center transition duration-150">
                            SF9 - Report Cards
                        </a>
                        <a href="/sf/sf10" class="w-full bg-orange-600 hover:bg-orange-700 text-white px-3 py-2 rounded text-sm inline-flex items-center justify-center transition duration-150">
                            SF10 - Permanent Records
                        </a>
                    </div>
                </div>
            </div>

            <!-- Books & Attendance -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Books & Attendance</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <a href="/sf/sf3" class="w-full bg-teal-600 hover:bg-teal-700 text-white px-3 py-2 rounded text-sm inline-flex items-center justify-center transition duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Book Management
                        </a>
                        <a href="/sf/sf2" class="w-full bg-teal-600 hover:bg-teal-700 text-white px-3 py-2 rounded text-sm inline-flex items-center justify-center transition duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            Attendance Report
                        </a>
                    
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">System Overview</h3>
            </div>
            <div class="p-6">
                <div class="text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <h4 class="text-lg font-medium text-gray-900 mb-2">DepEd LIS System</h4>
                    <p class="text-sm text-gray-600 max-w-2xl mx-auto">
                        Manage your school's learning information system with role-based access control. 
                        Create adviser accounts, manage classes, and oversee the dynamic School Forms generation system.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Message Modal -->
<div id="successModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2" id="modalTitle">Success!</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500" id="modalMessage">Operation completed successfully.</p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="modalClose" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle success modal
    const modal = document.getElementById('successModal');
    const modalClose = document.getElementById('modalClose');
    
    if (modalClose) {
        modalClose.addEventListener('click', function() {
            modal.classList.add('hidden');
        });
    }
    
    // Auto-hide modal after 3 seconds
    function showModal(title, message) {
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('modalMessage').textContent = message;
        modal.classList.remove('hidden');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 3000);
    }
    
    // Global function for other scripts
    window.showSuccessModal = showModal;
});
</script>
@endsection