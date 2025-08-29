@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">SF9 - Report Card</h1>
    <p class="text-gray-600">Generate and manage student report cards</p>
</div>

<!-- Filter Section -->
<div class="bg-white rounded-lg shadow border border-gray-200 p-6 mb-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Generate Report Cards</h3>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
            <label class="block text-sm font-medium text-gray-700 mb-2">Quarter</label>
            <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Select Quarter</option>
                <option value="1">1st Quarter</option>
                <option value="2">2nd Quarter</option>
                <option value="3">3rd Quarter</option>
                <option value="4">4th Quarter</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">School Year</label>
            <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="2024-2025" selected>2024-2025</option>
                <option value="2025-2026">2025-2026</option>
            </select>
        </div>
        <div class="flex items-end">
            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Generate SF9</button>
        </div>
    </div>
</div>

<!-- SF9 Preview -->
<div class="bg-white rounded-lg shadow border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">SF9 Preview - Grade 7 Section A | 1st Quarter</h3>
        <div class="flex space-x-2">
            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">Download All PDF</button>
            <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm">Print All</button>
        </div>
    </div>
    
    <!-- SF9 Form Template -->
    <div class="p-6">
        <div class="border border-gray-300 p-6 bg-white" style="font-family: 'Times New Roman', serif;">
            <!-- Header -->
            <div class="text-center mb-6">
                <div class="text-xs mb-2">Republic of the Philippines</div>
                <div class="text-xs mb-2">Department of Education</div>
                <div class="text-xs mb-4">Region IV-A CALABARZON</div>
                <div class="text-lg font-bold mb-2">LEARNER'S PROGRESS REPORT CARD</div>
                <div class="text-sm mb-2">(SF9 - Student Permanent Record)</div>
                <div class="text-xs">School Year: 2024-2025</div>
            </div>

            <!-- Student Information -->
            <div class="grid grid-cols-2 gap-6 mb-6 text-xs">
                <div>
                    <div class="mb-2"><strong>Name:</strong> DELA CRUZ, JUAN ANTONIO</div>
                    <div class="mb-2"><strong>LRN:</strong> 123456789012</div>
                    <div class="mb-2"><strong>Grade & Section:</strong> Grade 7 - Section A</div>
                    <div class="mb-2"><strong>School:</strong> Sample Elementary School</div>
                </div>
                <div>
                    <div class="mb-2"><strong>Age:</strong> 13</div>
                    <div class="mb-2"><strong>Sex:</strong> Male</div>
                    <div class="mb-2"><strong>Address:</strong> 123 Sample St., Sample City</div>
                    <div class="mb-2"><strong>Parent/Guardian:</strong> Juan Dela Cruz Sr.</div>
                </div>
            </div>

            <!-- Grades Table -->
            <div class="mb-6">
                <table class="w-full border-collapse border border-gray-400 text-xs">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-400 p-2 text-left">LEARNING AREAS</th>
                            <th class="border border-gray-400 p-2 text-center">1st Quarter</th>
                            <th class="border border-gray-400 p-2 text-center">2nd Quarter</th>
                            <th class="border border-gray-400 p-2 text-center">3rd Quarter</th>
                            <th class="border border-gray-400 p-2 text-center">4th Quarter</th>
                            <th class="border border-gray-400 p-2 text-center">Final Grade</th>
                            <th class="border border-gray-400 p-2 text-center">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-400 p-2">Mathematics</td>
                            <td class="border border-gray-400 p-2 text-center">86</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-400 p-2">Science</td>
                            <td class="border border-gray-400 p-2 text-center">88</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-400 p-2">English</td>
                            <td class="border border-gray-400 p-2 text-center">85</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-400 p-2">Filipino</td>
                            <td class="border border-gray-400 p-2 text-center">87</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-400 p-2">Araling Panlipunan</td>
                            <td class="border border-gray-400 p-2 text-center">89</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-400 p-2">Values Education</td>
                            <td class="border border-gray-400 p-2 text-center">90</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-400 p-2">MAPEH</td>
                            <td class="border border-gray-400 p-2 text-center">91</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-400 p-2">TLE</td>
                            <td class="border border-gray-400 p-2 text-center">88</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="border border-gray-400 p-2 font-bold">GENERAL AVERAGE</td>
                            <td class="border border-gray-400 p-2 text-center font-bold">88.0</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                            <td class="border border-gray-400 p-2 text-center">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Attendance -->
            <div class="mb-6">
                <h4 class="font-bold text-sm mb-2">ATTENDANCE RECORD</h4>
                <table class="w-full border-collapse border border-gray-400 text-xs">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-400 p-2">Quarter</th>
                            <th class="border border-gray-400 p-2">School Days</th>
                            <th class="border border-gray-400 p-2">Days Present</th>
                            <th class="border border-gray-400 p-2">Days Absent</th>
                            <th class="border border-gray-400 p-2">Times Tardy</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-400 p-2 text-center">1st Quarter</td>
                            <td class="border border-gray-400 p-2 text-center">45</td>
                            <td class="border border-gray-400 p-2 text-center">44</td>
                            <td class="border border-gray-400 p-2 text-center">1</td>
                            <td class="border border-gray-400 p-2 text-center">2</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Signatures -->
            <div class="grid grid-cols-2 gap-6 text-xs">
                <div>
                    <div class="mb-4">
                        <div class="border-b border-gray-400 mb-1 h-8"></div>
                        <div class="text-center">Class Adviser</div>
                    </div>
                </div>
                <div>
                    <div class="mb-4">
                        <div class="border-b border-gray-400 mb-1 h-8"></div>
                        <div class="text-center">Parent/Guardian Signature</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Student List for SF9 Generation -->
<div class="mt-6 bg-white rounded-lg shadow border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Students - Grade 7 Section A</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">General Average</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
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
                        <span class="text-sm font-medium text-gray-900">88.0</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Complete</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="flex justify-center space-x-2">
                            <button class="text-blue-600 hover:text-blue-900 text-sm">View</button>
                            <button class="text-green-600 hover:text-green-900 text-sm">Download PDF</button>
                            <button class="text-purple-600 hover:text-purple-900 text-sm">Print</button>
                        </div>
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
                        <span class="text-sm font-medium text-gray-900">90.3</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Complete</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="flex justify-center space-x-2">
                            <button class="text-blue-600 hover:text-blue-900 text-sm">View</button>
                            <button class="text-green-600 hover:text-green-900 text-sm">Download PDF</button>
                            <button class="text-purple-600 hover:text-purple-900 text-sm">Print</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
