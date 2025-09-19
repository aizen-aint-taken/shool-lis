@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Attendance Reports</h1>
                    <p class="text-gray-600">
                        @if(auth()->user()->role === 'admin')
                            View and analyze attendance data for all classes
                        @else
                            View and analyze attendance data for your classes
                        @endif
                    </p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('attendance.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                        Back to Attendance
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Filter Reports</h3>
            
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Class</label>
                    <select name="class_id" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="">All Classes</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->grade_level }} - {{ $class->section }}
                                @if(auth()->user()->role === 'admin' && $class->adviser)
                                    ({{ $class->adviser->name }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" name="start_date" value="{{ request('start_date', date('Y-m-01')) }}" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" name="end_date" value="{{ request('end_date', date('Y-m-d')) }}" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Generate Report
                    </button>
                </div>
            </form>
        </div>

        <!-- Report Content -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Attendance Report</h3>
                <p class="text-sm text-gray-600">
                    {{ request('start_date', date('Y-m-01')) }} to {{ request('end_date', date('Y-m-d')) }}
                </p>
            </div>
            
            <div class="p-6">
                <div class="text-center text-gray-500 py-8">
                    <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <h4 class="text-lg font-medium text-gray-900 mb-2">Attendance Reports</h4>
                    <p class="text-sm text-gray-600">Select filters above to generate detailed attendance reports.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection