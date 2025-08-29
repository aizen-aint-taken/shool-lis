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
                    <div class="w-8 h-8 bg-blue-600 rounded flex items-center justify-center">
                        <span class="text-white font-bold text-sm">DepEd</span>
                    </div>
                    <span class="text-gray-800 font-semibold text-lg">Learner Information System</span>
                    <span class="text-gray-500 text-sm">| Adviser Portal</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">Welcome, Adviser</span>
                    <a href="{{ url('/portal/login') }}" class="text-blue-600 hover:text-blue-800 text-sm">Logout</a>
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
                        My Classes
                    </a>
                    <a href="{{ url('/students') }}" class="px-3 py-4 text-sm font-medium hover:bg-blue-600 border-b-2 {{ request()->is('students*') ? 'border-white' : 'border-transparent' }}">
                        Students
                    </a>
                    <a href="{{ url('/grades') }}" class="px-3 py-4 text-sm font-medium hover:bg-blue-600 border-b-2 {{ request()->is('grades*') ? 'border-white' : 'border-transparent' }}">
                        Grade Encoding
                    </a>
                    
                    <!-- School Forms Dropdown -->
                    <div class="relative group">
                        <button class="px-3 py-4 text-sm font-medium hover:bg-blue-600 border-b-2 {{ request()->is('sf*') ? 'border-white' : 'border-transparent' }} flex items-center">
                            School Forms
                            <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div class="absolute left-0 mt-0 w-56 bg-white text-gray-800 shadow-lg rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <a href="{{ url('/sf9') }}" class="block px-4 py-3 text-sm hover:bg-gray-100 border-b border-gray-100">SF9 - Report Card</a>
                            <a href="{{ url('/sf10') }}" class="block px-4 py-3 text-sm hover:bg-gray-100 border-b border-gray-100">SF10 - Learner's Permanent Academic Record</a>
                            <a href="{{ url('/sf1') }}" class="block px-4 py-3 text-sm hover:bg-gray-100">SF1 - School Register</a>
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
