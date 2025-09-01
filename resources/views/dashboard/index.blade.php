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


</div>

<!-- My Classes Overview -->

@endsection
