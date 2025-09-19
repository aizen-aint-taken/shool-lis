@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Attendance Management</h1>
                    <p class="text-gray-600">
                        @if(auth()->user()->role === 'admin')
                            Administrator view - All classes attendance overview
                        @else
                            Manage daily attendance for your advised classes
                        @endif
                    </p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500">{{ auth()->user()->name }}</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        @if(auth()->user()->role === 'admin') bg-blue-100 text-blue-800 @else bg-green-100 text-green-800 @endif">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @foreach($attendanceStats as $classId => $stats)
                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">{{ $stats['class']->grade_level }} - {{ $stats['class']->section }}</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['today_present'] }}/{{ $stats['class']->students->count() }} Present Today</dd>
                                    <dd class="text-xs text-gray-500">{{ $stats['overall_stats']['attendance_rate'] }}% Overall Rate</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Class Management Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($classes as $class)
                <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ $class->grade_level }} - {{ $class->section }}</h3>
                                <p class="text-sm text-gray-600">
                                    {{ $class->students->count() }} Students 
                                    @if(auth()->user()->role === 'admin' && $class->adviser)
                                        | Adviser: {{ $class->adviser->name }}
                                    @endif
                                    | {{ $class->school_year }}
                                </p>
                            </div>
                            <div class="flex space-x-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Active
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Today's Attendance Summary -->
                        @if(isset($attendanceStats[$class->id]))
                            @php $todayStats = $attendanceStats[$class->id] @endphp
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Today's Attendance</h4>
                                <div class="grid grid-cols-3 gap-4 text-center">
                                    <div>
                                        <div class="text-lg font-bold text-green-600">{{ $todayStats['today_present'] }}</div>
                                        <div class="text-xs text-gray-500">Present</div>
                                    </div>
                                    <div>
                                        <div class="text-lg font-bold text-red-600">{{ $todayStats['today_absent'] }}</div>
                                        <div class="text-xs text-gray-500">Absent</div>
                                    </div>
                                    <div>
                                        <div class="text-lg font-bold text-yellow-600">{{ $todayStats['today_late'] }}</div>
                                        <div class="text-xs text-gray-500">Late</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Action Buttons -->
                        <div class="space-y-3">
                            @if(auth()->user()->role === 'adviser')
                                <a href="{{ route('attendance.daily', $class->id) }}" 
                                   class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center justify-center transition duration-150">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                    Record Daily Attendance
                                </a>
                            @endif
                            
                            <a href="{{ route('attendance.reports') }}?class_id={{ $class->id }}" 
                               class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg inline-flex items-center justify-center transition duration-150">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                View Reports
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($classes->isEmpty())
            <div class="text-center py-12">
                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">
                    @if(auth()->user()->role === 'admin')
                        No Classes Available
                    @else
                        No Classes Assigned
                    @endif
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if(auth()->user()->role === 'admin')
                        No active classes found in the system.
                    @else
                        You haven't been assigned to any classes yet. Contact your administrator.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
        {{ session('error') }}
    </div>
@endif
@endsection