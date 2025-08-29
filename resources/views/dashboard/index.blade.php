@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Adviser Dashboard</h1>
    <p class="text-gray-600">Welcome to the DepEd Learner Information System</p>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">My Classes</h2>
                <p class="text-2xl font-bold text-gray-900">3</p>
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
                <p class="text-2xl font-bold text-gray-900">127</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">Pending Forms</h2>
                <p class="text-2xl font-bold text-gray-900">8</p>
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
                <h2 class="text-sm font-medium text-gray-500">Grades Encoded</h2>
                <p class="text-2xl font-bold text-gray-900">89%</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities & Quick Actions -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Activities -->
    <div class="bg-white rounded-lg shadow border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Recent Activities</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">Grade 7-A Mathematics grades updated</p>
                        <p class="text-xs text-gray-500">2 hours ago</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">New student enrolled: Juan Dela Cruz</p>
                        <p class="text-xs text-gray-500">1 day ago</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 bg-yellow-400 rounded-full"></div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">SF9 forms generated for Q1</p>
                        <p class="text-xs text-gray-500">3 days ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ url('/students/create') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-900">Enroll Student</span>
                </a>
                
                <a href="{{ url('/grades/encode') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-8 h-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-900">Encode Grades</span>
                </a>
                
                <a href="{{ url('/sf9') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-8 h-8 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-900">Generate SF9</span>
                </a>
                
                <a href="{{ url('/classes') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-8 h-8 text-orange-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-900">Manage Classes</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- My Classes Overview -->
<div class="mt-8 bg-white rounded-lg shadow border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">My Classes</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Students</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">School Year</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">Grade 7 - Section A</div>
                        <div class="text-sm text-gray-500">Mathematics</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">42</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2024-2025</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ url('/classes/1') }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                        <a href="{{ url('/grades/encode/1') }}" class="text-green-600 hover:text-green-900">Encode Grades</a>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">Grade 8 - Section B</div>
                        <div class="text-sm text-gray-500">Science</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">38</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2024-2025</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ url('/classes/2') }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                        <a href="{{ url('/grades/encode/2') }}" class="text-green-600 hover:text-green-900">Encode Grades</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
