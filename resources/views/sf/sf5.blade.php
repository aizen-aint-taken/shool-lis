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

<!-- Class Selection Form -->
<div class="bg-white rounded-lg shadow border border-gray-200 mb-6">
    <div class="p-6">
        <form method="GET" action="{{ route('sf.sf5') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="class_id" class="block text-sm font-medium text-gray-700 mb-2">Select Class</label>
                <select name="class_id" id="class_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Select Class --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $selectedClass && $selectedClass->id == $class->id ? 'selected' : '' }}>
                            {{ $class->class_name }} - {{ $class->adviser->name ?? 'No Adviser' }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Generate Report
                </button>
            </div>
        </form>
    </div>
</div>

@if($selectedClass)
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
                    <span class="text-gray-900">{{ $schoolInfo['school_name'] }}</span>
                </div>
                <div class="flex">
                    <span class="font-medium text-gray-700 w-32">School ID:</span>
                    <span class="text-gray-900">{{ $schoolInfo['school_id'] }}</span>
                </div>
                <div class="flex">
                    <span class="font-medium text-gray-700 w-32">Division:</span>
                    <span class="text-gray-900">{{ $schoolInfo['division'] }}</span>
                </div>
                <div class="flex">
                    <span class="font-medium text-gray-700 w-32">Region:</span>
                    <span class="text-gray-900">{{ $schoolInfo['region'] }}</span>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex">
                    <span class="font-medium text-gray-700 w-32">School Year:</span>
                    <span class="text-gray-900">{{ $selectedClass->school_year }}</span>
                </div>
                <div class="flex">
                    <span class="font-medium text-gray-700 w-32">Grade Level:</span>
                    <span class="text-gray-900">Grade {{ $selectedClass->grade_level }}</span>
                </div>
                <div class="flex">
                    <span class="font-medium text-gray-700 w-32">Section:</span>
                    <span class="text-gray-900">{{ $selectedClass->section }}</span>
                </div>
                <div class="flex">
                    <span class="font-medium text-gray-700 w-32">Adviser:</span>
                    <span class="text-gray-900">{{ $selectedClass->adviser->name ?? 'Not Assigned' }}</span>
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
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Dropped</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Advanced</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Proficient</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Beginning</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Grade {{ $selectedClass->grade_level }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">{{ $performanceStats['grade_stats']['total_enrolled'] ?? 0 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-green-600 font-medium">{{ $performanceStats['grade_stats']['promoted'] ?? 0 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-yellow-600 font-medium">{{ $performanceStats['grade_stats']['retained'] ?? 0 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-blue-600 font-medium">{{ $performanceStats['grade_stats']['dropped'] ?? 0 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-green-600 font-medium">{{ $performanceStats['grade_stats']['advanced'] ?? 0 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-yellow-600 font-medium">{{ $performanceStats['grade_stats']['proficient'] ?? 0 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-orange-600 font-medium">{{ $performanceStats['grade_stats']['beginning'] ?? 0 }}</td>
                </tr>
            </tbody>
            <tfoot class="bg-blue-50">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">TOTAL</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-gray-900">{{ $performanceStats['grade_stats']['total_enrolled'] ?? 0 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-green-600">{{ $performanceStats['grade_stats']['promoted'] ?? 0 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-yellow-600">{{ $performanceStats['grade_stats']['retained'] ?? 0 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-blue-600">{{ $performanceStats['grade_stats']['dropped'] ?? 0 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-green-600">{{ $performanceStats['grade_stats']['advanced'] ?? 0 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-yellow-600">{{ $performanceStats['grade_stats']['proficient'] ?? 0 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-orange-600">{{ $performanceStats['grade_stats']['beginning'] ?? 0 }}</td>
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
                        <p class="text-2xl font-semibold text-green-900">{{ $performanceStats['promotion_rate'] ?? 0 }}%</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-blue-50 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="ml-4">
                        <p class="text-sm font-medium text-blue-600">Advanced Learners</p>
                        <p class="text-2xl font-semibold text-blue-900">{{ $performanceStats['advanced_learners'] ?? 0 }}%</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-yellow-50 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="ml-4">
                        <p class="text-sm font-medium text-yellow-600">Retention Rate</p>
                        <p class="text-2xl font-semibold text-yellow-900">{{ $performanceStats['retention_rate'] ?? 0 }}%</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-orange-50 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="ml-4">
                        <p class="text-sm font-medium text-orange-600">Beginning Level</p>
                        <p class="text-2xl font-semibold text-orange-900">{{ $performanceStats['beginning_level'] ?? 0 }}%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection