@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Individual Learners Quarterly Grade by Learning Area</h1>
    <p class="text-gray-600">Encode quarterly grades for individual students across all learning areas</p>
</div>

<!-- Student Selection -->
<div class="bg-white rounded-lg shadow border border-gray-200 p-6 mb-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Select Student and Academic Year</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Student</label>
            <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Select Student</option>
                <option value="1">Dela Cruz, Juan A. (LRN: 123456789012)</option>
                <option value="2">Santos, Maria B. (LRN: 123456789013)</option>
                <option value="3">Reyes, Anna C. (LRN: 123456789014)</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Grade Level</label>
            <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Select Grade</option>
                <option value="7">Grade 7</option>
                <option value="8">Grade 8</option>
                <option value="9">Grade 9</option>
                <option value="10">Grade 10</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">School Year</label>
            <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Select School Year</option>
                <option value="2023-2024">2023-2024</option>
                <option value="2024-2025">2024-2025</option>
            </select>
        </div>
    </div>
    <div class="mt-4">
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Load Student Grades</button>
    </div>
</div>

<!-- Quarterly Grade Encoding Table -->
<div class="bg-white rounded-lg shadow border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">Individual Learners Quarterly Grade by Learning Area</h3>
        <div class="flex space-x-2">
            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">Save All Grades</button>
            <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm">Generate Report Card</button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Learning Area</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">1st Quarter</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">2nd Quarter</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">3rd Quarter</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">4th Quarter</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Final Grade</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Filipino -->
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">Filipino</td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="85">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="87">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="86">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="88">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <span class="text-sm font-medium text-gray-900">86.5</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">PASSED</span>
                    </td>
                </tr>
                
                <!-- English -->
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">English</td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="89">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="91">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="88">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="90">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <span class="text-sm font-medium text-gray-900">89.5</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">PASSED</span>
                    </td>
                </tr>
                
                <!-- Mathematics -->
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">Mathematics</td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="92">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="88">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="90">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="89">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <span class="text-sm font-medium text-gray-900">89.8</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">PASSED</span>
                    </td>
                </tr>
                
                <!-- Araling Panlipunan -->
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">Araling Panlipunan</td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="84">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="86">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="85">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="87">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <span class="text-sm font-medium text-gray-900">85.5</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">PASSED</span>
                    </td>
                </tr>
                
                <!-- Edukasyon sa Pagpapakatao -->
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">Edukasyon sa Pagpapakatao</td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="95">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="93">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="94">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="96">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <span class="text-sm font-medium text-gray-900">94.5</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">PASSED</span>
                    </td>
                </tr>
                
                <!-- MAPEH -->
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">MAPEH</td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="88">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="90">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="89">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" value="91">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <span class="text-sm font-medium text-gray-900">89.5</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">PASSED</span>
                    </td>
                </tr>
                
                <!-- Music (sub-component of MAPEH) -->
                <tr class="hover:bg-gray-50 bg-gray-25">
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-700 border-r border-gray-200 pl-8">Music</td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" placeholder="">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" placeholder="">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" placeholder="">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" placeholder="">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <span class="text-sm font-medium text-gray-400">-</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">-</span>
                    </td>
                </tr>
                
                <!-- Arts -->
                <tr class="hover:bg-gray-50 bg-gray-25">
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-700 border-r border-gray-200 pl-8">Arts</td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" placeholder="">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" placeholder="">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" placeholder="">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" placeholder="">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <span class="text-sm font-medium text-gray-400">-</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">-</span>
                    </td>
                </tr>
                
                <!-- Physical Education -->
                <tr class="hover:bg-gray-50 bg-gray-25">
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-700 border-r border-gray-200 pl-8">Physical Education</td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" placeholder="">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" placeholder="">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" placeholder="">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" placeholder="">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <span class="text-sm font-medium text-gray-400">-</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">-</span>
                    </td>
                </tr>
                
                <!-- Health -->
                <tr class="hover:bg-gray-50 bg-gray-25">
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-700 border-r border-gray-200 pl-8">Health</td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" placeholder="">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" placeholder="">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" placeholder="">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" placeholder="">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <span class="text-sm font-medium text-gray-400">-</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">-</span>
                    </td>
                </tr>
                
                <!-- Mother Tongue -->
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">Mother Tongue</td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" placeholder="">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" placeholder="">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" placeholder="">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" min="60" max="100" placeholder="">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                        <span class="text-sm font-medium text-gray-400">-</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">-</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- General Average -->
<div class="mt-6 bg-white rounded-lg shadow border border-gray-200 p-6">
    <div class="text-center">
        <div class="text-lg font-medium text-gray-900 mb-2">General Average</div>
        <div class="text-3xl font-bold text-blue-600">88.6</div>
    </div>
</div>
@endsection
