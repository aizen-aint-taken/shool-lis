@extends('layouts.app')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">SF3 - Books/Textbooks Monitoring</h1>
            <p class="text-gray-600">Textbook and Learning Material Distribution Record</p>
        </div>
        <div class="flex items-center space-x-4">
            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                Export Excel
            </button>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                Print
            </button>
        </div>
    </div>
</div>

<!-- School Information Header -->
<div class="bg-white rounded-lg shadow border border-gray-200 mb-6">
    <div class="p-6">
        <div class="text-center mb-6">
            <h2 class="text-lg font-bold text-gray-900">TEXTBOOK AND LEARNING MATERIAL DISTRIBUTION RECORD</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <div class="flex">
                    <span class="font-medium text-gray-700 w-32">School:</span>
                    <span class="text-gray-900">Maharlika National High School</span>
                </div>
                <div class="flex">
                    <span class="font-medium text-gray-700 w-32">School ID:</span>
                    <span class="text-gray-900">304866</span>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex">
                    <span class="font-medium text-gray-700 w-32">Grade & Section:</span>
                    <select class="border border-gray-300 rounded px-2 py-1 text-sm">
                        <option value="7a">Grade 7 - Section A</option>
                        <option value="7b">Grade 7 - Section B</option>
                    </select>
                </div>
                <div class="flex">
                    <span class="font-medium text-gray-700 w-32">School Year:</span>
                    <span class="text-gray-900">2025-2026</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Books Distribution Record -->
<div class="bg-white rounded-lg shadow border border-gray-200">
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse border border-gray-400">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">No.</th>
                        <th class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">LEARNER'S NAME</th>
                        <th class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">LRN</th>
                        <th class="border border-gray-400 px-2 py-1 text-xs font-medium text-gray-700 text-center">Book Title</th>
                        <th class="border border-gray-400 px-2 py-1 text-xs font-medium text-gray-700 text-center">Subject</th>
                        <th class="border border-gray-400 px-2 py-1 text-xs font-medium text-gray-700 text-center">Book No.</th>
                        <th class="border border-gray-400 px-2 py-1 text-xs font-medium text-gray-700 text-center">Condition</th>
                        <th class="border border-gray-400 px-2 py-1 text-xs font-medium text-gray-700 text-center">Date Distributed</th>
                        <th class="border border-gray-400 px-2 py-1 text-xs font-medium text-gray-700 text-center">Status</th>
                        <th class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">REMARKS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">1</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs">DELA CRUZ, Juan Miguel</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">304866202500001</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs">Mathematics 7 Textbook</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">Math</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">MTH-7-001</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">Good</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">08/15/2025</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">
                            <span class="px-1 py-0.5 bg-green-100 text-green-800 rounded text-xs">Distributed</span>
                        </td>
                        <td class="border border-gray-400 px-2 py-1 text-xs">Good condition</td>
                    </tr>
                    
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">2</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs">SANTOS, Maria Luz</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">304866202500002</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs">Mathematics 7 Textbook</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">Math</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">MTH-7-002</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">New</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">08/15/2025</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">
                            <span class="px-1 py-0.5 bg-green-100 text-green-800 rounded text-xs">Distributed</span>
                        </td>
                        <td class="border border-gray-400 px-2 py-1 text-xs">Responsible student</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Summary Section -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="space-y-2">
                <h4 class="font-semibold text-gray-900">Distribution Summary</h4>
                <div class="text-sm space-y-1">
                    <div class="flex justify-between">
                        <span>Total Books Distributed:</span>
                        <span class="font-bold">126</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Books Returned:</span>
                        <span class="font-bold">3</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Books Lost/Damaged:</span>
                        <span class="font-bold text-red-600">1</span>
                    </div>
                </div>
            </div>
            
            <div class="space-y-2">
                <h4 class="font-semibold text-gray-900">Book Condition</h4>
                <div class="text-sm space-y-1">
                    <div class="flex justify-between">
                        <span>New:</span>
                        <span class="font-bold text-green-600">45</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Good:</span>
                        <span class="font-bold text-blue-600">68</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Fair:</span>
                        <span class="font-bold text-yellow-600">12</span>
                    </div>
                </div>
            </div>
            
            <div class="space-y-2">
                <h4 class="font-semibold text-gray-900">Legend</h4>
                <div class="text-sm space-y-1">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-green-100 border border-green-300"></div>
                        <span>Distributed</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-yellow-100 border border-yellow-300"></div>
                        <span>Returned</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-red-100 border border-red-300"></div>
                        <span>Lost/Damaged</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection