@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">My Classes</h1>
        <p class="text-gray-600">Manage your assigned classes and students</p>
    </div>
    <a href="{{ url('/classes/create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Add New Class
    </a>
</div>

<!-- Class Statistics -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">Active Classes</h2>
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
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">Average Grade</h2>
                <p class="text-2xl font-bold text-gray-900">87.5</p>
            </div>
        </div>
    </div>
</div>

<!-- Classes Table -->
<div class="bg-white rounded-lg shadow border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Class List</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class Information</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade Level</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Students</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">School Year</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-sm font-medium text-blue-600">7A</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">Grade 7 - Section A</div>
                                <div class="text-sm text-gray-500">Mathematics & Science</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Grade 7</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">42/45</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2024-2025</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ url('/classes/1/view') }}" class="text-blue-600 hover:text-blue-900">View</a>
                            <a href="{{ url('/classes/1/edit') }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <a href="{{ url('/grades/encode/1') }}" class="text-green-600 hover:text-green-900">Grades</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <span class="text-sm font-medium text-green-600">8B</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">Grade 8 - Section B</div>
                                <div class="text-sm text-gray-500">Science & English</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Grade 8</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">38/40</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2024-2025</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ url('/classes/2/view') }}" class="text-blue-600 hover:text-blue-900">View</a>
                            <a href="{{ url('/classes/2/edit') }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <a href="{{ url('/grades/encode/2') }}" class="text-green-600 hover:text-green-900">Grades</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                    <span class="text-sm font-medium text-purple-600">9C</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">Grade 9 - Section C</div>
                                <div class="text-sm text-gray-500">Mathematics & Filipino</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Grade 9</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">47/50</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2024-2025</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ url('/classes/3/view') }}" class="text-blue-600 hover:text-blue-900">View</a>
                            <a href="{{ url('/classes/3/edit') }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <a href="{{ url('/grades/encode/3') }}" class="text-green-600 hover:text-green-900">Grades</a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
