<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DepEd LIS - Adviser Portal</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">
    <div class="min-h-screen flex flex-col">
        <!-- Top Header -->
        <header class="bg-white border-b border-gray-200 px-4 py-3 shadow-sm">
            <div class="flex items-center justify-between max-w-7xl mx-auto">
                <div class="flex items-center space-x-3">
                    <div class="w-8 px-8 bg-blue-600 rounded flex items-center justify-center">
                        <span class="text-white font-bold text-sm">DepEd</span>
                    </div>
                    <span class="text-gray-800 font-semibold text-lg">{{auth()->user()->name}}</span>
                    <span class="text-gray-500 text-sm"> || {{auth()->user()->name}}</span>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-sm text-gray-600">Welcome, {{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm">Logout</button>
                        </form>
                    @else
                        <a href="{{ url('/portal/login') }}" class="text-blue-600 hover:text-blue-800 text-sm">Login</a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Navigation Bar -->
        <nav class="bg-blue-700 text-white shadow">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex space-x-8">
                    <a href="{{ url('/dashboard') }}" class="px-3 py-4 text-sm font-medium hover:bg-blue-600 border-b-2 {{ request()->is('dashboard') ? 'border-white' : 'border-transparent' }}">
                        Dashboard
                    </a>
                    <a href="{{ url('/classes') }}" class="px-3 py-4 text-sm font-medium hover:bg-blue-600 border-b-2 {{ request()->is('classes*') ? 'border-white' : 'border-transparent' }}">
                        Class Management
                    </a>
                    @auth
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'adviser')
                        <!-- Student Management Dropdown -->
                        <div class="relative group">
                            <button class="text-white hover:text-gray-200 px-3 py-4 rounded-md text-sm font-medium flex items-center border-b-2 {{ request()->is('students*') ? 'border-white' : 'border-transparent' }}">
                                Student Management
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
                                <div class="py-1">
                                    <a href="{{ route('students.create') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                        <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Enroll New Student
                                    </a>
                                    <a href="{{ route('students.index') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                        <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        Manage Students
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Grades Dropdown -->
                        <div class="relative group">
                            <button class="text-white hover:text-gray-200 px-3 py-4 rounded-md text-sm font-medium flex items-center border-b-2 {{ request()->is('grades*') ? 'border-white' : 'border-transparent' }}">
                                Grades
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
                                <div class="py-1">
                                    <a href="{{ url('/grades/view-only') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                        <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        View Student Grades
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if(auth()->user()->role === 'teacher')
                        <a href="{{ url('/teacher-portal') }}" class="px-3 py-4 text-sm font-medium hover:bg-blue-600 border-b-2 {{ request()->is('teacher-portal*') ? 'border-white' : 'border-transparent' }}">
                            Subject Teacher Portal
                        </a>
                        @endif
                    @endauth
                    
                    <!-- School Forms Dropdown -->
                    <div class="relative group">
                        <button class="text-white hover:text-gray-200 px-3 py-4 rounded-md text-sm font-medium flex items-center">
                            School Forms
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
                            <div class="py-1">
                                <a href="{{ url('/sf/sf1') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    SF1 - School Register
                                </a>
                                <a href="{{ url('/sf/sf2') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    SF2 - Enrollment & Attendance
                                </a>
                                <a href="{{ url('/sf/sf3') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    SF3 - Books/Textbooks Monitor
                                </a>
                                <a href="{{ url('/sf/sf5') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    SF5 - Promotions & Proficiency
                                </a>
                                <a href="{{ url('/sf/sf9') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    SF9 - Report Card
                                </a>
                                <a href="{{ url('/sf/sf10') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    SF10 - Permanent Record
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-1 max-w-7xl mx-auto w-full px-4 py-6">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-100 border-t border-gray-200 py-4">
            <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-600">
                Department of Education - Learner Information System © {{ date('Y') }}
            </div>
        </footer>
    </div>
</body>
</html>
