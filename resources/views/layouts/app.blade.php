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

        <!-- Navigation Bar - Role-Based Access Control -->
      <!-- resources/views/layouts/app.blade.php -->
<nav class="bg-blue-700 text-white shadow">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex space-x-8">
            @auth
                @if(auth()->user()->role === 'admin')
                    <!-- ADMIN NAVIGATION -->
                    <a href="{{ url('/admin/dashboard') }}" class="px-3 py-4 text-sm font-medium hover:bg-blue-600 border-b-2 {{ request()->is('admin/dashboard*') ? 'border-white' : 'border-transparent' }}">
                        Admin Dashboard
                    </a>
                    <a href="{{ url('/admin/users') }}" class="px-3 py-4 text-sm font-medium hover:bg-blue-600 border-b-2 {{ request()->is('admin/users*') ? 'border-white' : 'border-transparent' }}">
                        User Management
                    </a>
                    <!-- Admin Class Management Dropdown -->
                    <div class="relative group">
                        <button class="text-white hover:text-gray-200 px-3 py-4 rounded-md text-sm font-medium flex items-center border-b-2 {{ request()->is('admin/classes*') || request()->is('classes*') ? 'border-white' : 'border-transparent' }}">
                            Class Management
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
                            <div class="py-1">
                                <a href="{{ url('/admin/classes') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    View All Classes
                                </a>
                                <a href="{{ url('/admin/classes/create') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Create New Class
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Admin School Forms Dropdown -->
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
                                    SF1 - School Register
                                </a>
                                <a href="{{ url('/sf/sf2') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    SF2 - Daily Attendance
                                </a>
                                <a href="{{ url('/sf/sf3') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    SF3 - Books Monitoring
                                </a>
                                <a href="{{ url('/sf/sf5') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    SF5 - Promotion Report
                                </a>
                                <a href="{{ url('/sf/sf9') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    SF9 - Report Cards
                                </a>
                                <a href="{{ url('/sf/sf10') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    SF10 - Permanent Records
                                </a>
                                <!-- Add SF8 here -->
                                <a href="{{ url('/sf/sf8') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    SF8 - Health & Nutrition
                                </a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('/grades/view-only') }}" class="px-3 py-4 text-sm font-medium hover:bg-blue-600 border-b-2 {{ request()->is('grades/view-only*') ? 'border-white' : 'border-transparent' }}">
                        View Grades
                    </a>
                    
                @elseif(auth()->user()->role === 'adviser')
                    <!-- ADVISER NAVIGATION -->
                    <a href="{{ url('/dashboard') }}" class="px-3 py-4 text-sm font-medium hover:bg-blue-600 border-b-2 {{ request()->is('dashboard*') ? 'border-white' : 'border-transparent' }}">
                        Dashboard
                    </a>
                    <a href="{{ url('/classes') }}" class="px-3 py-4 text-sm font-medium hover:bg-blue-600 border-b-2 {{ request()->is('classes*') ? 'border-white' : 'border-transparent' }}">
                        My Classes
                    </a>
                    <a href="{{ url('/students') }}" class="px-3 py-4 text-sm font-medium hover:bg-blue-600 border-b-2 {{ request()->is('students*') ? 'border-white' : 'border-transparent' }}">
                        Students
                    </a>
                    <a href="{{ url('/attendance') }}" class="px-3 py-4 text-sm font-medium hover:bg-blue-600 border-b-2 {{ request()->is('attendance*') ? 'border-white' : 'border-transparent' }}">
                        Attendance
                    </a>
                    <!-- Adviser School Forms Dropdown -->
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
                                    SF1 - School Register
                                </a>
                                <a href="{{ url('/sf/sf2') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    SF2 - Daily Attendance
                                </a>
                                <a href="{{ url('/sf/sf3') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    SF3 - Books Monitoring
                                </a>
                                <a href="{{ url('/sf/sf5') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    SF5 - Promotion Report
                                </a>
                                <a href="{{ url('/sf/sf9') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    SF9 - Report Cards
                                </a>
                                <a href="{{ url('/sf/sf10') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    SF10 - Permanent Records
                                </a>
                                <!-- Add SF8 here -->
                                <a href="{{ url('/sf/sf8') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    SF8 - Health & Nutrition
                                </a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('/grades/view-only') }}" class="px-3 py-4 text-sm font-medium hover:bg-blue-600 border-b-2 {{ request()->is('grades/view-only*') ? 'border-white' : 'border-transparent' }}">
                        View Grades
                    </a>
                    
                @elseif(auth()->user()->role === 'teacher')
                    <!-- TEACHER NAVIGATION -->
                    <a href="{{ url('/teacher-portal') }}" class="px-3 py-4 text-sm font-medium hover:bg-blue-600 border-b-2 {{ request()->is('teacher-portal*') ? 'border-white' : 'border-transparent' }}">
                        Dashboard
                    </a>
                    <a href="{{ url('/teacher-portal/classes') }}" class="px-3 py-4 text-sm font-medium hover:bg-blue-600 border-b-2 {{ request()->is('teacher-portal/classes*') ? 'border-white' : 'border-transparent' }}">
                        My Classes
                    </a>
                    <a href="{{ url('/grades/encode') }}" class="px-3 py-4 text-sm font-medium hover:bg-blue-600 border-b-2 {{ request()->is('grades/encode*') || request()->is('grades') ? 'border-white' : 'border-transparent' }}">
                        Encode Grades
                    </a>
                    <a href="{{ url('/teacher-portal/reports') }}" class="px-3 py-4 text-sm font-medium hover:bg-blue-600 border-b-2 {{ request()->is('teacher-portal/reports*') ? 'border-white' : 'border-transparent' }}">
                        Reports
                    </a>
                    
                @elseif(auth()->user()->role === 'student')
                    <!-- STUDENT NAVIGATION -->
                    <a href="{{ url('/portal/grades') }}" class="px-3 py-4 text-sm font-medium hover:bg-blue-600 border-b-2 {{ request()->is('portal/grades*') ? 'border-white' : 'border-transparent' }}">
                        My Grades
                    </a>
                @endif
            @else
                <!-- GUEST NAVIGATION -->
                <a href="{{ url('/portal/login') }}" class="px-3 py-4 text-sm font-medium hover:bg-blue-600">
                    Login
                </a>
            @endauth
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
    
    <!-- Role-Based Access Control Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Clear browser history on role-sensitive pages to prevent back button access
            if (typeof history.replaceState === 'function') {
                const userRole = '{{ auth()->check() ? auth()->user()->role : "guest" }}';
                const currentPath = window.location.pathname;
                
                // Define role-specific allowed paths
                const rolePermissions = {
                    'admin': ['/admin/', '/sf/', '/grades/view-only', '/books', '/attendance/reports', '/classes'],
                    'adviser': ['/dashboard', '/classes', '/students', '/attendance', '/sf/', '/grades/view-only'],
                    'teacher': ['/teacher-portal', '/grades'],
                    'student': ['/portal/grades', '/grades/view'],
                    'guest': ['/portal/login', '/login', '/']
                };
                
                // Check if current user has access to current path
                function hasAccess(role, path) {
                    if (!rolePermissions[role]) return false;
                    return rolePermissions[role].some(allowedPath => path.startsWith(allowedPath));
                }
                
                // Redirect if unauthorized access detected
                if (!hasAccess(userRole, currentPath)) {
                    console.warn('Unauthorized access detected, redirecting...');
                    switch(userRole) {
                        case 'admin':
                            window.location.replace('/admin/dashboard');
                            break;
                        case 'adviser':
                            window.location.replace('/dashboard');
                            break;
                        case 'teacher':
                            window.location.replace('/teacher-portal');
                            break;
                        case 'student':
                            window.location.replace('/portal/grades');
                            break;
                        default:
                            window.location.replace('/portal/login');
                    }
                }
                
                // Clear history to prevent back button exploitation
                history.replaceState(null, null, currentPath);
            }
            
            // Show warning messages if they exist
            @if(session('warning'))
                alert('{{ session('warning') }}');
            @endif
            
            // Prevent context menu and certain key combinations for security
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
            });
            
            
        });
        
        // Handle logout with session cleanup
        function secureLogout() {
            if (confirm('Are you sure you want to logout?')) {
                // Clear any cached data
                if (typeof sessionStorage !== 'undefined') {
                    sessionStorage.clear();
                }
                if (typeof localStorage !== 'undefined') {
                    localStorage.clear();
                }
                
                // Submit logout form
                document.querySelector('form[action*="logout"]').submit();
            }
        }
    </script>
</body>
</html>
