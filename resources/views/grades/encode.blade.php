@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Grade Encoding</h1>
    <p class="text-gray-600">Encode and manage student grades for your classes</p>
</div>

<!-- Class Selection -->
<div class="bg-white rounded-lg shadow border border-gray-200 p-6 mb-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Select Class and Quarter</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Class</label>
            <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Select Class</option>
                <option value="1">Grade 7 - Section A</option>
                <option value="2">Grade 8 - Section B</option>
                <option value="3">Grade 9 - Section C</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
            <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Select Subject</option>
                <option value="math">Mathematics</option>
                <option value="science">Science</option>
                <option value="english">English</option>
                <option value="filipino">Filipino</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Quarter</label>
            <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Select Quarter</option>
                <option value="1">1st Quarter</option>
                <option value="2">2nd Quarter</option>
                <option value="3">3rd Quarter</option>
                <option value="4">4th Quarter</option>
            </select>
        </div>
    </div>
    <div class="mt-4">
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Load Students</button>
    </div>
</div>

<!-- Grade Entry Table -->
<div class="bg-white rounded-lg shadow border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">Grade 7 - Section A | Mathematics | 1st Quarter</h3>
        <div class="flex space-x-2">
            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">Save All Grades</button>
            <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm">Generate SF9</button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Written Works<br><span class="text-xs normal-case">(30%)</span></th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Performance Tasks<br><span class="text-xs normal-case">(50%)</span></th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Quarterly Assessment<br><span class="text-xs normal-case">(20%)</span></th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Initial Grade</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Quarterly Grade</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8">
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-xs font-medium text-blue-600">JD</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">Dela Cruz, Juan A.</div>
                                <div class="text-sm text-gray-500">LRN: 123456789012</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm" min="0" max="100" value="85">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm" min="0" max="100" value="88">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm" min="0" max="100" value="82">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="text-sm font-medium text-gray-900">85.9</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">86</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <button class="text-blue-600 hover:text-blue-900 text-sm">Save</button>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8">
                                <div class="h-8 w-8 rounded-full bg-pink-100 flex items-center justify-center">
                                    <span class="text-xs font-medium text-pink-600">MS</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">Santos, Maria B.</div>
                                <div class="text-sm text-gray-500">LRN: 123456789013</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm" min="0" max="100" value="92">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm" min="0" max="100" value="90">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm" min="0" max="100" value="89">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="text-sm font-medium text-gray-900">90.3</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">90</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <button class="text-blue-600 hover:text-blue-900 text-sm">Save</button>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8">
                                <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <span class="text-xs font-medium text-green-600">AR</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">Reyes, Anna C.</div>
                                <div class="text-sm text-gray-500">LRN: 123456789014</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm" min="0" max="100" placeholder="0">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm" min="0" max="100" placeholder="0">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="number" class="w-16 text-center border border-gray-300 rounded px-2 py-1 text-sm" min="0" max="100" placeholder="0">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="text-sm font-medium text-gray-400">-</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">-</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <button class="text-blue-600 hover:text-blue-900 text-sm">Save</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Grade Summary -->
<div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <div class="text-sm font-medium text-gray-500">Class Average</div>
        <div class="text-2xl font-bold text-blue-600">88.1</div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <div class="text-sm font-medium text-gray-500">Highest Grade</div>
        <div class="text-2xl font-bold text-green-600">90</div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <div class="text-sm font-medium text-gray-500">Lowest Grade</div>
        <div class="text-2xl font-bold text-red-600">86</div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <div class="text-sm font-medium text-gray-500">Completion Rate</div>
        <div class="text-2xl font-bold text-purple-600">67%</div>
    </div>
</div>
@endsection
