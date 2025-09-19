@extends('layouts.app')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">SF2 - Daily Attendance Report</h1>
            <p class="text-gray-600">Dynamic Daily Attendance Record of Learners</p>
        </div>
        <div class="flex items-center space-x-4">
            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                Export Excel
            </button>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium" onclick="window.print()">
                Print
            </button>
        </div>
    </div>
</div>

<!-- Class and Month Selection -->
<div class="bg-white rounded-lg shadow border border-gray-200 mb-6">
    <div class="p-6">
        <form method="GET" action="{{ route('sf.sf2') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
            
            <div>
                <label for="month" class="block text-sm font-medium text-gray-700 mb-2">Month</label>
                <select name="month" id="month" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($monthOptions as $value => $label)
                        <option value="{{ $value }}" {{ $selectedMonth == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700 mb-2">Year</label>
                <select name="year" id="year" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($yearOptions as $year)
                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
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
            <h2 class="text-lg font-bold text-gray-900">DAILY ATTENDANCE RECORD OF LEARNERS</h2>
            <p class="text-sm text-gray-600">(To be accomplished by the Class Adviser)</p>
            <div class="mt-2 text-sm text-blue-600 font-medium">
                Real-time data from {{ $monthOptions[$selectedMonth] }} {{ $selectedYear }}
            </div>
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
                    <span class="font-medium text-gray-700 w-32">Grade & Section:</span>
                    <span class="text-gray-900">{{ $selectedClass->class_name }}</span>
                </div>
                <div class="flex">
                    <span class="font-medium text-gray-700 w-32">School Year:</span>
                    <span class="text-gray-900">{{ $selectedClass->school_year }}</span>
                </div>
                <div class="flex">
                    <span class="font-medium text-gray-700 w-32">Class Adviser:</span>
                    <span class="text-gray-900">{{ $selectedClass->adviser->name ?? 'Not Assigned' }}</span>
                </div>
                <div class="flex">
                    <span class="font-medium text-gray-700 w-32">Month:</span>
                    <span class="text-gray-900">{{ $monthOptions[$selectedMonth] }} {{ $selectedYear }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Attendance Record -->
<div class="bg-white rounded-lg shadow border border-gray-200">
    <div class="p-6">
        @if($students->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500">No students found in this class.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th rowspan="2" class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">No.</th>
                            <th rowspan="2" class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center min-w-48">LEARNER'S NAME</th>
                            <th rowspan="2" class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">LRN</th>
                            <th rowspan="2" class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">SEX</th>
                            <th rowspan="2" class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">ENROLLMENT</th>
                            <th colspan="{{ $daysInMonth }}" class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">DAYS OF THE MONTH</th>
                            <th rowspan="2" class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">PRESENT</th>
                            <th rowspan="2" class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">ABSENT</th>
                            <th rowspan="2" class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">RATE</th>
                        </tr>
                        <tr class="bg-gray-100">
                            @for($day = 1; $day <= $daysInMonth; $day++)
                            <th class="border border-gray-400 px-1 py-1 text-xs font-medium text-gray-700 text-center w-6">{{ $day }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $index => $student)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-400 px-2 py-1 text-xs text-center">{{ $index + 1 }}</td>
                            <td class="border border-gray-400 px-2 py-1 text-xs">
                                {{ strtoupper($student->last_name) }}, {{ $student->first_name }}
                            </td>
                            <td class="border border-gray-400 px-2 py-1 text-xs text-center">{{ $student->lrn }}</td>
                            <td class="border border-gray-400 px-2 py-1 text-xs text-center">{{ $student->gender == 'Male' ? 'M' : 'F' }}</td>
                            <td class="border border-gray-400 px-2 py-1 text-xs text-center">{{ $student->created_at ? $student->created_at->format('m/d/Y') : 'N/A' }}</td>
                            
                            @for($day = 1; $day <= $daysInMonth; $day++)
                            <td class="border border-gray-400 px-1 py-1 text-xs text-center">
                                @if(isset($attendanceData[$student->id][$day]))
                                    @php $status = $attendanceData[$student->id][$day]; @endphp
                                    @if($status === 'present')
                                        <span class="text-green-600 font-bold">✓</span>
                                    @elseif($status === 'absent')
                                        <span class="text-red-600 font-bold">✗</span>
                                    @elseif($status === 'late')
                                        <span class="text-yellow-600 font-bold">L</span>
                                    @elseif($status === 'excused')
                                        <span class="text-blue-600 font-bold">E</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                @else
                                    <span class="text-gray-300">-</span>
                                @endif
                            </td>
                            @endfor
                            
                            @php $stats = $monthlyStats[$student->id] ?? ['total_present' => 0, 'total_absent' => 0, 'attendance_rate' => 0]; @endphp
                            <td class="border border-gray-400 px-2 py-1 text-xs text-center font-bold text-green-600">{{ $stats['total_present'] }}</td>
                            <td class="border border-gray-400 px-2 py-1 text-xs text-center font-bold text-red-600">{{ $stats['total_absent'] }}</td>
                            <td class="border border-gray-400 px-2 py-1 text-xs text-center font-bold 
                                {{ $stats['attendance_rate'] >= 95 ? 'text-green-600' : ($stats['attendance_rate'] >= 85 ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ $stats['attendance_rate'] }}%
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Note about real-time data -->
            <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                <p class="text-sm text-blue-700">
                    <strong>📊 Real-time Data:</strong> This SF2 report automatically reflects attendance data encoded by advisers. 
                    When you mark attendance, it instantly updates this form - no manual editing required!
                </p>
            </div>
        @endif
    </div>
</div>
@else
    <div class="bg-white rounded-lg shadow border border-gray-200">
        <div class="p-8 text-center">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Select a Class</h3>
            <p class="text-gray-600">Please select a class and month to generate the SF2 Daily Attendance Report.</p>
        </div>
    </div>
@endif

<script>
document.getElementById('class_id').addEventListener('change', function() {
    if (this.value) {
        this.form.submit();
    }
});

</script>

@endsection