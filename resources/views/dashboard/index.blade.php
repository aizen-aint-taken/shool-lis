@extends('layouts.app')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-blue-600 text-sm">304866 - Maharlika National High School</p>
        </div>
        <div class="flex items-center space-x-4">
            <button class="bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded text-sm">
                Explore
                <svg class="inline w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>
    </div>
</div>

<!-- Date Selector -->
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div class="text-sm text-gray-600">
            <span>Today</span>
            <div class="font-medium text-gray-900">Sep 1, SY 2025-2026</div>
        </div>
        <div class="flex items-center space-x-2">
            <select class="border border-gray-300 rounded px-3 py-2 text-sm bg-white">
                <option>Sep 1, SY 2025-2026</option>
            </select>
        </div>
    </div>
</div>

<!-- Enrollment Overview -->
<div class="bg-white rounded-lg shadow border border-gray-200 mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">Enrollment</h3>
            <div class="flex space-x-4">
                <button class="text-blue-600 border-b-2 border-blue-600 px-2 py-1 text-sm font-medium">Overview</button>
                <button class="text-gray-600 hover:text-gray-900 px-2 py-1 text-sm font-medium">Summary</button>
            </div>
        </div>
    </div>
    
    <!-- Total Enrollment Card -->
    <div class="p-6">
        <div class="text-center mb-6">
            <div class="text-sm text-gray-600 mb-2">Total Enrollment</div>
            <div class="text-6xl font-bold text-gray-900 mb-4">420</div>
            <div class="flex justify-center space-x-8">
                <div class="text-center">
                    <div class="text-sm text-gray-600">Male</div>
                    <div class="text-2xl font-bold text-blue-600">192</div>
                </div>
                <div class="text-center">
                    <div class="text-sm text-gray-600">Female</div>
                    <div class="text-2xl font-bold text-pink-600">228</div>
                </div>
            </div>
        </div>
        
        <!-- Grade Level Breakdown -->
        <div class="mt-6">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-t border-gray-200">
                            <th class="text-left py-2 px-4 text-sm font-medium text-gray-600">Grade Level</th>
                            <th class="text-center py-2 px-4 text-sm font-medium text-gray-600">G7</th>
                            <th class="text-center py-2 px-4 text-sm font-medium text-gray-600">G8</th>
                            <th class="text-center py-2 px-4 text-sm font-medium text-gray-600">G9</th>
                            <th class="text-center py-2 px-4 text-sm font-medium text-gray-600">G10</th>
                            <th class="text-center py-2 px-4 text-sm font-medium text-gray-600">G11</th>
                            <th class="text-center py-2 px-4 text-sm font-medium text-gray-600">NG</th>
                            <th class="text-center py-2 px-4 text-sm font-medium text-gray-600">T</th>
                            <th class="text-center py-2 px-4 text-sm font-medium text-gray-600">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t border-gray-200">
                            <td class="py-2 px-4 text-sm font-medium text-gray-900">Total</td>
                            <td class="text-center py-2 px-4">
                                <div class="text-xs text-blue-600 font-medium">M</div>
                                <div class="text-sm font-bold">62</div>
                                <div class="text-xs text-pink-600 font-medium">F</div>
                                <div class="text-sm font-bold">67</div>
                                <div class="text-xs text-gray-600 font-medium">T</div>
                                <div class="text-sm font-bold">129</div>
                            </td>
                            <td class="text-center py-2 px-4">
                                <div class="text-xs text-blue-600 font-medium">M</div>
                                <div class="text-sm font-bold">47</div>
                                <div class="text-xs text-pink-600 font-medium">F</div>
                                <div class="text-sm font-bold">49</div>
                                <div class="text-xs text-gray-600 font-medium">T</div>
                                <div class="text-sm font-bold">96</div>
                            </td>
                            <td class="text-center py-2 px-4">
                                <div class="text-xs text-blue-600 font-medium">M</div>
                                <div class="text-sm font-bold">47</div>
                                <div class="text-xs text-pink-600 font-medium">F</div>
                                <div class="text-sm font-bold">55</div>
                                <div class="text-xs text-gray-600 font-medium">T</div>
                                <div class="text-sm font-bold">102</div>
                            </td>
                            <td class="text-center py-2 px-4">
                                <div class="text-xs text-blue-600 font-medium">M</div>
                                <div class="text-sm font-bold">36</div>
                                <div class="text-xs text-pink-600 font-medium">F</div>
                                <div class="text-sm font-bold">57</div>
                                <div class="text-xs text-gray-600 font-medium">T</div>
                                <div class="text-sm font-bold">93</div>
                            </td>
                            <td class="text-center py-2 px-4">
                                <div class="text-xs text-blue-600 font-medium">M</div>
                                <div class="text-sm font-bold">0</div>
                                <div class="text-xs text-pink-600 font-medium">F</div>
                                <div class="text-sm font-bold">0</div>
                                <div class="text-xs text-gray-600 font-medium">T</div>
                                <div class="text-sm font-bold">0</div>
                            </td>
                            <td class="text-center py-2 px-4">
                                <div class="text-xs text-blue-600 font-medium">M</div>
                                <div class="text-sm font-bold">0</div>
                                <div class="text-xs text-pink-600 font-medium">F</div>
                                <div class="text-sm font-bold">0</div>
                                <div class="text-xs text-gray-600 font-medium">T</div>
                                <div class="text-sm font-bold">0</div>
                            </td>
                            <td class="text-center py-2 px-4">
                                <div class="text-xs text-blue-600 font-medium">M</div>
                                <div class="text-sm font-bold">0</div>
                                <div class="text-xs text-pink-600 font-medium">F</div>
                                <div class="text-sm font-bold">0</div>
                                <div class="text-xs text-gray-600 font-medium">T</div>
                                <div class="text-sm font-bold">0</div>
                            </td>
                            <td class="text-center py-2 px-4">
                                <div class="text-xs text-blue-600 font-medium">M</div>
                                <div class="text-sm font-bold text-blue-600">192</div>
                                <div class="text-xs text-pink-600 font-medium">F</div>
                                <div class="text-sm font-bold text-pink-600">228</div>
                                <div class="text-xs text-gray-600 font-medium">T</div>
                                <div class="text-sm font-bold text-gray-900">420</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 text-center">
                <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Toggle Segments</button>
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
            @if(auth()->user()->role === 'admin')
            <div class="space-y-3">
                <a href="{{ url('/grades/view-only') }}" class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">View Student Grades</div>
                        <div class="text-xs text-gray-500">Monitor grades encoded by teachers</div>
                    </div>
                </a>
                <a href="{{ url('/grades/dashboard') }}" class="flex items-center p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                    <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">Real-time Dashboard</div>
                        <div class="text-xs text-gray-500">Live grade encoding activities</div>
                    </div>
                </a>
                <a href="{{ url('/classes') }}" class="flex items-center p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
                    <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">Manage Classes</div>
                        <div class="text-xs text-gray-500">View and manage all classes</div>
                    </div>
                </a>
            </div>
            @elseif(auth()->user()->role === 'adviser')
            <div class="space-y-3">
                <a href="{{ url('/grades/view-only') }}" class="flex items-center p-3 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors">
                    <div class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">View Class Grades</div>
                        <div class="text-xs text-gray-500">Monitor your advised classes</div>
                    </div>
                </a>
                <a href="{{ url('/grades/dashboard') }}" class="flex items-center p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                    <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">Real-time Dashboard</div>
                        <div class="text-xs text-gray-500">Live grade updates for your classes</div>
                    </div>
                </a>
            </div>
            @elseif(auth()->user()->role === 'teacher')
            <div class="space-y-3">
                <a href="{{ url('/teacher-portal/grades/encode') }}" class="flex items-center p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                    <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">Encode Grades</div>
                        <div class="text-xs text-gray-500">Input student grades and scores</div>
                    </div>
                </a>
                <a href="{{ url('/teacher-portal') }}" class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">Teacher Portal</div>
                        <div class="text-xs text-gray-500">Access teacher resources</div>
                    </div>
                </a>
            </div>
            @else
            <div class="text-center text-gray-500 py-4">
                <p class="text-sm">No quick actions available for your role.</p>
            </div>
            @endif
        </div>
    </div>


</div>

<!-- My Classes Overview -->

@endsection
