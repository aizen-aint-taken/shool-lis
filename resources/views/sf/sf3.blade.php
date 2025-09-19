@extends('layouts.app')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">SF3 - Books/Textbooks Monitoring</h1>
            <p class="text-gray-600">Dynamic Textbook and Learning Material Distribution Record</p>
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

<!-- Class and Filter Selection -->
<div class="bg-white rounded-lg shadow border border-gray-200 mb-6">
    <div class="p-6">
        <form method="GET" action="{{ route('sf.sf3') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status Filter</label>
                <select name="status" id="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($statusOptions as $value => $label)
                        <option value="{{ $value }}" {{ $selectedStatus == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-2">Academic Year</label>
                <select name="academic_year" id="academic_year" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($academicYearOptions as $year)
                        <option value="{{ $year }}" {{ $selectedAcademicYear == $year ? 'selected' : '' }}>{{ $year }}</option>
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
            <h2 class="text-lg font-bold text-gray-900">TEXTBOOK AND LEARNING MATERIAL DISTRIBUTION RECORD</h2>
            <div class="mt-2 text-sm text-blue-600 font-medium">
                Real-time data for {{ $selectedClass->class_name }} - {{ $selectedAcademicYear }}
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
                    <span class="font-medium text-gray-700 w-32">Status Filter:</span>
                    <span class="text-gray-900">{{ $statusOptions[$selectedStatus] }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Books Distribution Record -->
<div class="bg-white rounded-lg shadow border border-gray-200">
    <div class="p-6">
        @if($bookIssues->isEmpty())
            <div class="text-center py-8">
                <div class="mb-4">
                    <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Book Records Found</h3>
                <p class="text-gray-600">No book distribution records found for the selected criteria.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">No.</th>
                            <th class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">LEARNER'S NAME</th>
                            <th class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">LRN</th>
                            <th class="border border-gray-400 px-2 py-1 text-xs font-medium text-gray-700 text-center">BOOK TITLE</th>
                            <th class="border border-gray-400 px-2 py-1 text-xs font-medium text-gray-700 text-center">SUBJECT</th>
                            <th class="border border-gray-400 px-2 py-1 text-xs font-medium text-gray-700 text-center">BOOK CODE</th>
                            <th class="border border-gray-400 px-2 py-1 text-xs font-medium text-gray-700 text-center">CONDITION</th>
                            <th class="border border-gray-400 px-2 py-1 text-xs font-medium text-gray-700 text-center">DATE ISSUED</th>
                            <th class="border border-gray-400 px-2 py-1 text-xs font-medium text-gray-700 text-center">STATUS</th>
                            <th class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">REMARKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookIssues as $index => $issue)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-400 px-2 py-1 text-xs text-center">{{ $index + 1 }}</td>
                            <td class="border border-gray-400 px-2 py-1 text-xs">
                                {{ strtoupper($issue->student->last_name) }}, {{ $issue->student->first_name }}
                            </td>
                            <td class="border border-gray-400 px-2 py-1 text-xs text-center">{{ $issue->student->lrn }}</td>
                            <td class="border border-gray-400 px-2 py-1 text-xs">{{ $issue->book->title }}</td>
                            <td class="border border-gray-400 px-2 py-1 text-xs text-center">{{ $issue->book->subject }}</td>
                            <td class="border border-gray-400 px-2 py-1 text-xs text-center">{{ $issue->book->book_code }}</td>
                            <td class="border border-gray-400 px-2 py-1 text-xs text-center">
                                <span class="capitalize {{ $issue->issue_condition === 'new' ? 'text-green-600' : ($issue->issue_condition === 'good' ? 'text-blue-600' : ($issue->issue_condition === 'fair' ? 'text-yellow-600' : 'text-red-600')) }}">
                                    {{ $issue->issue_condition }}
                                </span>
                            </td>
                            <td class="border border-gray-400 px-2 py-1 text-xs text-center">{{ $issue->issue_date->format('m/d/Y') }}</td>
                            <td class="border border-gray-400 px-2 py-1 text-xs text-center">
                                @if($issue->status === 'issued')
                                    @if($issue->isOverdue())
                                        <span class="px-1 py-0.5 bg-red-100 text-red-800 rounded text-xs font-medium">Overdue</span>
                                    @else
                                        <span class="px-1 py-0.5 bg-blue-100 text-blue-800 rounded text-xs font-medium">Issued</span>
                                    @endif
                                @elseif($issue->status === 'returned')
                                    <span class="px-1 py-0.5 bg-green-100 text-green-800 rounded text-xs font-medium">Returned</span>
                                @elseif($issue->status === 'lost')
                                    <span class="px-1 py-0.5 bg-red-100 text-red-800 rounded text-xs font-medium">Lost</span>
                                @elseif($issue->status === 'damaged')
                                    <span class="px-1 py-0.5 bg-orange-100 text-orange-800 rounded text-xs font-medium">Damaged</span>
                                @endif
                            </td>
                            <td class="border border-gray-400 px-2 py-1 text-xs">
                                {{ $issue->issue_remarks ?? '-' }}
                                @if($issue->penalty_amount > 0)
                                    <br><span class="text-red-600 font-medium">Penalty: ₱{{ number_format($issue->penalty_amount, 2) }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Summary Section -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <h4 class="font-semibold text-gray-900">Distribution Summary</h4>
                    <div class="text-sm space-y-1">
                        <div class="flex justify-between">
                            <span>Total Books Issued:</span>
                            <span class="font-bold">{{ $bookStats['total_issued'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Currently Issued:</span>
                            <span class="font-bold text-blue-600">{{ $bookStats['currently_issued'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Books Returned:</span>
                            <span class="font-bold text-green-600">{{ $bookStats['returned'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Books Lost:</span>
                            <span class="font-bold text-red-600">{{ $bookStats['lost'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Books Damaged:</span>
                            <span class="font-bold text-orange-600">{{ $bookStats['damaged'] }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <h4 class="font-semibold text-gray-900">Book Condition Distribution</h4>
                    <div class="text-sm space-y-1">
                        <div class="flex justify-between">
                            <span>New:</span>
                            <span class="font-bold text-green-600">{{ $bookStats['condition_new'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Good:</span>
                            <span class="font-bold text-blue-600">{{ $bookStats['condition_good'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Fair:</span>
                            <span class="font-bold text-yellow-600">{{ $bookStats['condition_fair'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Poor:</span>
                            <span class="font-bold text-red-600">{{ $bookStats['condition_poor'] }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <h4 class="font-semibold text-gray-900">Legend</h4>
                    <div class="text-sm space-y-1">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-blue-100 border border-blue-300 rounded"></div>
                            <span>Currently Issued</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-green-100 border border-green-300 rounded"></div>
                            <span>Returned</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-red-100 border border-red-300 rounded"></div>
                            <span>Lost/Overdue</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-orange-100 border border-orange-300 rounded"></div>
                            <span>Damaged</span>
                        </div>
                    </div>
                    
                    <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                        <p class="text-xs text-blue-700">
                            <strong>📚 Real-time Data:</strong> This SF3 report automatically reflects book distribution and return data. 
                            When advisers issue or process book returns, it instantly updates this form!
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@else
    <div class="bg-white rounded-lg shadow border border-gray-200">
        <div class="p-8 text-center">
            <div class="mb-4">
                <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Select a Class</h3>
            <p class="text-gray-600">Please select a class to generate the SF3 Books/Textbooks Monitoring Report.</p>
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