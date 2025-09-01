@extends('layouts.app')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Subject Teacher Portal</h1>
            <p class="text-gray-600">Grade Encoding and Subject Management for Teachers</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="text-sm text-gray-600">
                <span class="font-medium">Teacher:</span>
                <span>{{ auth()->user()->name ?? 'Subject Teacher' }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Teacher Info Card -->
<div class="bg-white rounded-lg shadow border border-gray-200 mb-6">
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-12 w-12">
                    <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <span class="text-lg font-medium text-blue-600">ST</span>
                    </div>
                </div>
                <div class="ml-4">
                    <div class="text-lg font-medium text-gray-900">Subject Teacher</div>
                    <div class="text-sm text-gray-500">Mathematics Department</div>
                </div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-gray-900">8</div>
                <div class="text-sm text-gray-600">Assigned Classes</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-gray-900">280</div>
                <div class="text-sm text-gray-600">Total Students</div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <a href="{{ url('/teacher-portal/grades/encode') }}" class="bg-white p-6 rounded-lg shadow border border-gray-200 hover:bg-gray-50 transition-colors">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">Encode Grades</h2>
                <p class="text-lg font-bold text-gray-900">Start</p>
            </div>
        </div>
    </a>
    
    <a href="{{ url('/teacher-portal/classes') }}" class="bg-white p-6 rounded-lg shadow border border-gray-200 hover:bg-gray-50 transition-colors">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">My Classes</h2>
                <p class="text-lg font-bold text-gray-900">View</p>
            </div>
        </div>
    </a>
    
    <a href="{{ url('/teacher-portal/reports') }}" class="bg-white p-6 rounded-lg shadow border border-gray-200 hover:bg-gray-50 transition-colors">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">Grade Reports</h2>
                <p class="text-lg font-bold text-gray-900">Generate</p>
            </div>
        </div>
    </a>
    
    <a href="{{ url('/teacher-portal/attendance') }}" class="bg-white p-6 rounded-lg shadow border border-gray-200 hover:bg-gray-50 transition-colors">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">Attendance</h2>
                <p class="text-lg font-bold text-gray-900">Track</p>
            </div>
        </div>
    </a>
</div>

<!-- My Teaching Load -->
<div class="bg-white rounded-lg shadow border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">My Teaching Load</h3>
            <div class="flex items-center space-x-4">
                <select class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                    <option value="2025-2026">SY 2025-2026</option>
                    <option value="2024-2025">SY 2024-2025</option>
                </select>
                <select class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                    <option value="q1">1st Quarter</option>
                    <option value="q2">2nd Quarter</option>
                    <option value="q3">3rd Quarter</option>
                    <option value="q4">4th Quarter</option>
                </select>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Students</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Schedule</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8">
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-xs font-medium text-blue-600">7A</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">Grade 7 - Section A</div>
                                <div class="text-sm text-gray-500">Morning Session</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">Mathematics</div>
                        <div class="text-sm text-gray-500">Core Subject</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">42</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div>MWF 8:00-9:00 AM</div>
                        <div class="text-xs text-gray-500">Room 101</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">Q1 Grades: 85%</div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 85%"></div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ url('/teacher-portal/grades/encode/7a-mathematics') }}" class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-2 py-1 rounded text-xs">
                                Encode Grades
                            </a>
                            <a href="{{ url('/teacher-portal/classes/7a') }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-2 py-1 rounded text-xs">
                                View Class
                            </a>
                        </div>
                    </td>
                </tr>
                
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8">
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-xs font-medium text-blue-600">7B</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">Grade 7 - Section B</div>
                                <div class="text-sm text-gray-500">Morning Session</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">Mathematics</div>
                        <div class="text-sm text-gray-500">Core Subject</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">38</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div>MWF 9:00-10:00 AM</div>
                        <div class="text-xs text-gray-500">Room 101</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">Q1 Grades: 78%</div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 78%"></div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ url('/teacher-portal/grades/encode/7b-mathematics') }}" class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-2 py-1 rounded text-xs">
                                Encode Grades
                            </a>
                            <a href="{{ url('/teacher-portal/classes/7b') }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-2 py-1 rounded text-xs">
                                View Class
                            </a>
                        </div>
                    </td>
                </tr>
                
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8">
                                <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center">
                                    <span class="text-xs font-medium text-purple-600">8A</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">Grade 8 - Section A</div>
                                <div class="text-sm text-gray-500">Morning Session</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">Mathematics</div>
                        <div class="text-sm text-gray-500">Core Subject</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">40</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div>TTH 10:00-11:00 AM</div>
                        <div class="text-xs text-gray-500">Room 102</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">Q1 Grades: 92%</div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 92%"></div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ url('/teacher-portal/grades/encode/8a-mathematics') }}" class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-2 py-1 rounded text-xs">
                                Encode Grades
                            </a>
                            <a href="{{ url('/teacher-portal/classes/8a') }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-2 py-1 rounded text-xs">
                                View Class
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection