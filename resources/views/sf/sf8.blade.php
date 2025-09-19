<!-- resources/views/sf/sf8.blade.php -->
@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School Form 8 (SF8) - Health & Nutrition Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body class="p-6 bg-gray-100">
    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-6">

        {{-- Class Selection (No Print) --}}
        <div class="no-print mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="text-lg font-medium text-blue-900 mb-3">Select Class for SF8 Generation</h3>
            <form method="GET" action="{{ route('sf.sf8') }}" class="flex items-end space-x-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-blue-700 mb-1">Class</label>
                    <select name="class_id" class="w-full border border-blue-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                        <option value="">Select a class...</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $selectedClass && $selectedClass->id == $class->id ? 'selected' : '' }}>
                            Grade {{ $class->grade_level }} - {{ $class->section }} ({{ $class->school_year }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    Generate SF8
                </button>
            </form>
        </div>

        @if(!$selectedClass)
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Select a Class to Generate SF8</h3>
            <p class="text-gray-600">Choose a class from the dropdown above to generate the School Form 8 (Health & Nutrition Report)</p>
        </div>
        @else

        {{-- Header --}}
        <div class="text-center border-b pb-4 mb-4">
            <h1 class="text-lg font-bold uppercase">School Form 8 (SF8) - Health & Nutrition Report</h1>
            <p class="text-sm italic">Student Health and Nutrition Assessment</p>
        </div>

        {{-- School Info --}}
        <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
            <div>
                <p><strong>Region:</strong> {{ $schoolInfo['region'] }}</p>
                <p><strong>School ID:</strong> {{ $schoolInfo['school_id'] }}</p>
                <p><strong>School Name:</strong> {{ $schoolInfo['school_name'] }}</p>
            </div>
            <div>
                <p><strong>Division:</strong> {{ $schoolInfo['division'] }}</p>
                <p><strong>District:</strong> {{ $schoolInfo['district'] }}</p>
                <p><strong>School Year:</strong> {{ $schoolInfo['school_year'] }}</p>
            </div>
        </div>

        {{-- Class Info --}}
        <div class="mb-4 text-sm">
            <p><strong>Grade Level:</strong> Grade {{ $selectedClass->grade_level }}</p>
            <p><strong>Section:</strong> {{ $selectedClass->section }}</p>
            <p><strong>Adviser:</strong> {{ $selectedClass->adviser ? $selectedClass->adviser->name : 'No adviser assigned' }}</p>
            <p><strong>Total Enrolled:</strong> {{ $students->count() }} students</p>
        </div>

        {{-- Learners Table --}}
        <table class="w-full border-collapse border text-xs">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border p-1 w-8">No.</th>
                    <th class="border p-1">LRN</th>
                    <th class="border p-1">Learner’s Name</th>
                    <th class="border p-1">Height (cm)</th>
                    <th class="border p-1">Weight (kg)</th>
                    <th class="border p-1">Nutritional Status</th>
                    <th class="border p-1">Health Condition</th>
                    <th class="border p-1">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $index => $student)
                <tr>
                    <td class="border p-1 text-center">{{ $index + 1 }}</td>
                    <td class="border p-1 text-center">{{ $student->lrn }}</td>
                    <td class="border p-1">{{ $student->last_name }}, {{ $student->first_name }}{{ $student->middle_name ? ' ' . substr($student->middle_name, 0, 1) . '.' : '' }}{{ $student->suffix ? ' ' . $student->suffix : '' }}</td>
                    <td class="border p-1 text-center"><input type="number" step="0.01" name="students[{{ $student->id }}][height]" class="w-full text-center border-none outline-none" value="{{ old('students.'.$student->id.'.height') }}"></td>
                    <td class="border p-1 text-center"><input type="number" step="0.01" name="students[{{ $student->id }}][weight]" class="w-full text-center border-none outline-none" value="{{ old('students.'.$student->id.'.weight') }}"></td>
                    <td class="border p-1 text-center">
                        <select name="students[{{ $student->id }}][nutritional_status]" class="w-full text-center border-none outline-none">
                            <option value="Normal" {{ old('students.'.$student->id.'.nutritional_status') == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Underweight" {{ old('students.'.$student->id.'.nutritional_status') == 'Underweight' ? 'selected' : '' }}>Underweight</option>
                            <option value="Overweight" {{ old('students.'.$student->id.'.nutritional_status') == 'Overweight' ? 'selected' : '' }}>Overweight</option>
                            <option value="Obese" {{ old('students.'.$student->id.'.nutritional_status') == 'Obese' ? 'selected' : '' }}>Obese</option>
                            <option value="Malnourished" {{ old('students.'.$student->id.'.nutritional_status') == 'Malnourished' ? 'selected' : '' }}>Malnourished</option>
                        </select>
                    </td>
                    <td class="border p-1"><input type="text" name="students[{{ $student->id }}][health_condition]" class="w-full border-none outline-none" value="{{ old('students.'.$student->id.'.health_condition') }}"></td>
                    <td class="border p-1"><input type="text" name="students[{{ $student->id }}][remarks]" class="w-full border-none outline-none" value="{{ old('students.'.$student->id.'.remarks') }}"></td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="border p-4 text-center text-gray-500">
                        No students enrolled in this class yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Footer --}}
        <div class="mt-6 text-sm">
            <div class="grid grid-cols-2 gap-8">
                <div>
                    <p><strong>Prepared by:</strong></p>
                    <div class="border-b border-gray-400 mt-8 mb-2"></div>
                    <p class="text-center">{{ $selectedClass->adviser ? $selectedClass->adviser->name : '_______________________________' }}</p>
                    <p class="text-center text-xs">Class Adviser</p>
                </div>
                <div>
                    <p><strong>Checked by:</strong></p>
                    <div class="border-b border-gray-400 mt-8 mb-2"></div>
                    <p class="text-center">_______________________________</p>
                    <p class="text-center text-xs">School Principal</p>
                </div>
            </div>
        </div>

        @endif

        <div class="no-print mt-6 flex space-x-4">
            <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print SF8
            </button>
            <a href="{{ route('classes.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                Back to Classes
            </a>
            @if($selectedClass)
            <a href="{{ route('students.create', ['class_id' => $selectedClass->id]) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Add Student to Class
            </a>
            @endif
        </div>
    </div>
</body>
</html>
@endsection