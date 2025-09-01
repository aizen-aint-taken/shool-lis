@extends('layouts.app')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">SF5 - Promotions & Proficiency Levels</h1>
            <p class="text-gray-600">Record of Learner Promotion and Academic Performance</p>
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
            <h2 class="text-lg font-bold text-gray-900">RECORD OF PROMOTIONS AND PROFICIENCY LEVELS</h2>
            <p class="text-sm text-gray-600">(Summary of Student Academic Performance and Promotion Status)</p>
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
                    <span class="font-medium text-gray-700 w-32">School Year:</span>
                    <span class="text-gray-900">2025-2026</span>
                </div>
                <div class="flex">
                    <span class="font-medium text-gray-700 w-32">Grade Level:</span>
                    <select class="border border-gray-300 rounded px-2 py-1 text-sm">
                        <option value="all">All Grade Levels</option>
                        <option value="7">Grade 7</option>
                        <option value="8">Grade 8</option>
                        <option value="9">Grade 9</option>
                        <option value="10">Grade 10</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Promotion Summary Table -->
<div class="bg-white rounded-lg shadow border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Promotion and Proficiency Summary</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade Level</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Total Enrolled</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Promoted</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Retained</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Advanced</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Proficient</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Developing</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Beginning</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Grade 7</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">80</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-green-600 font-medium">75</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-yellow-600 font-medium">3</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-blue-600 font-medium">12</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-green-600 font-medium">45</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-yellow-600 font-medium">18</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-orange-600 font-medium">5</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Grade 8</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">78</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-green-600 font-medium">72</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-yellow-600 font-medium">4</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-blue-600 font-medium">15</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-green-600 font-medium">42</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-yellow-600 font-medium">15</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-orange-600 font-medium">6</td>
                </tr>
            </tbody>
            <tfoot class="bg-blue-50">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">TOTAL</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-gray-900">325</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-green-600">305</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-yellow-600">12</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-blue-600">65</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-green-600">185</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-yellow-600">60</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-orange-600">15</td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <!-- Performance Summary Cards -->
    <div class="p-6 border-t border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-green-50 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="ml-4">
                        <p class="text-sm font-medium text-green-600">Promotion Rate</p>
                        <p class="text-2xl font-semibold text-green-900">93.8%</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-blue-50 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="ml-4">
                        <p class="text-sm font-medium text-blue-600">Advanced Learners</p>
                        <p class="text-2xl font-semibold text-blue-900">20%</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-yellow-50 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="ml-4">
                        <p class="text-sm font-medium text-yellow-600">Retention Rate</p>
                        <p class="text-2xl font-semibold text-yellow-900">3.7%</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-orange-50 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="ml-4">
                        <p class="text-sm font-medium text-orange-600">Beginning Level</p>
                        <p class="text-2xl font-semibold text-orange-900">4.6%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection