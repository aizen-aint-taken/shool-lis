<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DepEd LIS - Student Portal</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">
    <div class="min-h-screen flex flex-col">
        <!-- Top Header -->
        <header class="bg-white border-b border-gray-200 px-4 py-3 shadow-sm">
            <div class="flex items-center justify-between max-w-7xl mx-auto">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-8 bg-red-600 rounded flex items-center justify-center">
                        <span class="text-white font-bold text-sm">DepEd</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-800 font-semibold text-lg">Learner Information System</span>
                        <div class="flex items-center space-x-2 text-sm text-blue-600">
                            <span>304866 - Maharlika National High School</span>
                            <span class="text-gray-500">| Student Portal</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-600">
                        <span class="font-medium">{{ auth()->user()->name ?? 'Student Name' }}</span>
                    </div>
                    <a href="#" class="text-gray-600 hover:text-gray-800 text-sm">Help</a>
                    <a href="{{ url('/portal/login') }}" class="text-gray-600 hover:text-gray-800 text-sm">Sign out</a>
                </div>
            </div>
        </header>

        <!-- Navigation Bar -->
        <nav class="bg-gray-100 border-b border-gray-200 text-gray-700">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex space-x-8">
                    <a href="{{ url('/portal/dashboard') }}" class="px-3 py-4 text-sm font-medium hover:bg-gray-200 border-b-2 {{ request()->is('portal/dashboard') ? 'border-blue-600 text-blue-600' : 'border-transparent' }}">
                        Dashboard
                    </a>
                    <a href="{{ url('/portal/grades') }}" class="px-3 py-4 text-sm font-medium hover:bg-gray-200 border-b-2 {{ request()->is('portal/grades*') ? 'border-blue-600 text-blue-600' : 'border-transparent' }}">
                        My Grades
                    </a>
                    
                    <!-- School Forms Dropdown (Limited for Students) -->
                    <div class="relative group">
                        <button class="text-gray-700 hover:bg-gray-200 px-3 py-4 text-sm font-medium flex items-center border-b-2 border-transparent">
                            School Forms
                            <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
                            <div class="py-1">
                                <a href="{{ url('/portal/sf1') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>SF1 - School Register (View Only)
                                </a>
                                <a href="{{ url('/portal/sf2') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>SF2 - Enrollment & Attendance (View Only)
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ url('/portal/profile') }}" class="px-3 py-4 text-sm font-medium hover:bg-gray-200 border-b-2 {{ request()->is('portal/profile*') ? 'border-blue-600 text-blue-600' : 'border-transparent' }}">
                        My Profile
                    </a>
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