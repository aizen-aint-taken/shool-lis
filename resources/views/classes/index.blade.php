@extends('layouts.app')

@section('content')
<!-- Role-based Access Control -->
@if(auth()->user()->role === 'admin')
<div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6">
    <strong>Administrator Access:</strong> You can create, edit, and manage all classes and students.
</div>
@elseif(auth()->user()->role === 'adviser')
<div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
    <strong>Adviser Access:</strong> You can create and manage classes, and enroll students.
</div>
@else
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
    <strong>Access Denied:</strong> Only administrators and advisers can access class management.
</div>
@endif

@if(in_array(auth()->user()->role, ['admin', 'adviser']))

<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Class Management</h1>
            <p class="text-gray-600">Manage class sections and student enrollments - {{ auth()->user()->role === 'admin' ? 'Administrator' : 'Adviser' }}: {{ auth()->user()->name }}</p>
        </div>
        <div class="flex items-center space-x-4">
            {{-- Admin can  create classes only admin --}}
            @if (auth()->user()->role === 'admin') 
            <a href="{{ route('classes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Create New Class
            </a>
            @endif

            
            <a href="{{ auth()->user()->role === "admin" ? route('admin.students.create') : route('students.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Enroll Student
            </a>
        </div>
    </div>
</div>

<!-- Filter and Search -->
<div class="bg-white rounded-lg shadow border border-gray-200 mb-6">
    <div class="p-4">
        <form method="GET" action="{{ route('classes.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Grade Level</label>
                    <select name="grade_level" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                        <option value="">All Grades</option>
                        @if(isset($gradeLevels))
                            @foreach($gradeLevels as $level)
                                <option value="{{ $level }}" {{ request('grade_level') == $level ? 'selected' : '' }}>Grade {{ $level }}</option>
                            @endforeach
                        @else
                            <option value="7" {{ request('grade_level') == '7' ? 'selected' : '' }}>Grade 7</option>
                            <option value="8" {{ request('grade_level') == '8' ? 'selected' : '' }}>Grade 8</option>
                            <option value="9" {{ request('grade_level') == '9' ? 'selected' : '' }}>Grade 9</option>
                            <option value="10" {{ request('grade_level') == '10' ? 'selected' : '' }}>Grade 10</option>
                            <option value="11" {{ request('grade_level') == '11' ? 'selected' : '' }}>Grade 11</option>
                            <option value="12" {{ request('grade_level') == '12' ? 'selected' : '' }}>Grade 12</option>
                        @endif
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">School Year</label>
                    <select name="school_year" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                        <option value="">All Years</option>
                        @if(isset($schoolYears))
                            @foreach($schoolYears as $year)
                                <option value="{{ $year }}" {{ request('school_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        @else
                            <option value="2025-2026" {{ request('school_year') == '2025-2026' ? 'selected' : '' }}>2025-2026</option>
                            <option value="2024-2025" {{ request('school_year') == '2024-2025' ? 'selected' : '' }}>2024-2025</option>
                        @endif
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <div class="flex">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search classes..." class="flex-1 border border-gray-300 rounded-l-md px-3 py-2 text-sm">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r-md text-sm">
                            Search
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Classes Table -->
<div class="bg-white rounded-lg shadow border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">Class Sections</h3>
            <div class="text-sm text-gray-600">
                @if(isset($classes))
                    Showing {{ $classes->count() }} of {{ $classes->total() }} classes
                @else
                    No classes found
                @endif
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class Information</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Adviser</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrollment</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">School Year</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @if(isset($classes) && $classes->count() > 0)
                    @foreach($classes as $class)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-sm font-medium text-blue-600">{{ $class->grade_level }}{{ substr($class->section, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $class->class_name }}</div>
                                    <div class="text-sm text-gray-500">Grade {{ $class->grade_level }} - {{ $class->section }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($class->adviser)
                                <div class="text-sm text-gray-900">{{ $class->adviser->name }}</div>
                                <div class="text-sm text-gray-500">ID: {{ $class->adviser->id }}</div>
                            @else
                                <div class="text-sm text-gray-500">No Adviser Assigned</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $enrolledCount = $class->students->where('is_active', true)->count();
                                $percentage = $class->max_students > 0 ? ($enrolledCount / $class->max_students) * 100 : 0;
                                $colorClass = $percentage >= 90 ? 'bg-red-600' : ($percentage >= 70 ? 'bg-yellow-500' : 'bg-green-600');
                            @endphp
                            <div class="text-sm text-gray-900">
                                <span class="font-medium">{{ $enrolledCount }}</span> / {{ $class->max_students }} students
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                <div class="{{ $colorClass }} h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $class->school_year }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($class->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ auth()->user()->role === "admin" ? route('admin.classes.show', $class) : route('classes.show', $class) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-2 py-1 rounded text-xs">
                                    View
                                </a>
                                @auth
                                    @if(auth()->user()->role === "admin" || (auth()->user()->role === "adviser" && $class->adviser_id === auth()->id()))
                                    <a href="{{ auth()->user()->role === "admin" ? route('admin.classes.edit', $class) : route('classes.edit', $class) }}" class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-2 py-1 rounded text-xs">
                                        Edit
                                    </a>
                                    @endif
                                @endauth

                                @auth
                                    @if(auth()->user()->role === "admin")
                                    <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this class?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-2 py-1 rounded text-xs">
                                            Delete
                                        </button>
                                    </form>
                                    @endif
                                @endauth
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            <div class="py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No classes found</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new class.</p>
                                <div class="mt-6">
                                    <a href="{{ route('classes.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Create New Class
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    
    @if(isset($classes) && $classes->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $classes->withQueryString()->links() }}
    </div>
    @endif
</div>
                        

            
                
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
                @if($classes->total() > 0)
                    Showing {{ $classes->firstItem() }} to {{ $classes->lastItem() }} of {{ $classes->total() }} results
                @else
                    No results found
                @endif
            </div>
            @if($classes->hasPages())
            <div class="flex space-x-2">
                {{ $classes->withQueryString()->links('pagination::bootstrap-4') }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Quick Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">Total Classes</h2>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_classes'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">Total Students</h2>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_students'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">Active Classes</h2>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['active_classes'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">Advisers</h2>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_advisers'] }}</p>
            </div>
        </div>
    </div>
</div>

@endif

@endsection