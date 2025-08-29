@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-6">

        {{-- Header --}}
        <div class="text-center border-b pb-4 mb-4">
            <h1 class="text-lg font-bold uppercase">School Form 10 (SF10-JHS)</h1>
            <p class="italic">Learner’s Permanent Academic Record for Junior High School</p>
        </div>

        {{-- Learner Info --}}
        <div class="grid grid-cols-2 gap-4 mb-6 text-xs">
            <div>
                <p><strong>LRN:</strong> _____________________</p>
                <p><strong>Last Name:</strong> _________________</p>
                <p><strong>First Name:</strong> ________________</p>
                <p><strong>Middle Name:</strong> ______________</p>
            </div>
            <div>
                <p><strong>Birthdate:</strong> ________________</p>
                <p><strong>Sex:</strong> ____________________</p>
                <p><strong>School:</strong> _________________</p>
                <p><strong>School Year:</strong> ____________</p>
            </div>
        </div>

        {{-- Scholastic Records (per year level) --}}
        @foreach (['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10'] as $level)
        <div class="mb-6">
            <h2 class="text-base font-semibold mb-2">{{ $level }}</h2>
            <table class="w-full border-collapse border text-xs mb-2">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border p-1 w-1/5">Learning Areas</th>
                        <th class="border p-1">Quarter 1</th>
                        <th class="border p-1">Quarter 2</th>
                        <th class="border p-1">Quarter 3</th>
                        <th class="border p-1">Quarter 4</th>
                        <th class="border p-1">Final Grade</th>
                        <th class="border p-1">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Sample Rows --}}
                    <tr>
                        <td class="border p-1">Filipino</td>
                        <td class="border p-1 text-center">--</td>
                        <td class="border p-1 text-center">--</td>
                        <td class="border p-1 text-center">--</td>
                        <td class="border p-1 text-center">--</td>
                        <td class="border p-1 text-center">--</td>
                        <td class="border p-1 text-center">--</td>
                    </tr>
                    <tr>
                        <td class="border p-1">English</td>
                        <td class="border p-1 text-center">--</td>
                        <td class="border p-1 text-center">--</td>
                        <td class="border p-1 text-center">--</td>
                        <td class="border p-1 text-center">--</td>
                        <td class="border p-1 text-center">--</td>
                        <td class="border p-1 text-center">--</td>
                    </tr>
                    {{-- Add more subjects as needed --}}
                </tbody>
            </table>

            <div class="flex justify-between text-xs">
                <p><strong>General Average:</strong> _________</p>
                <p><strong>Action Taken:</strong> Promoted / Retained</p>
            </div>
        </div>
        @endforeach

        {{-- Certification --}}
        <div class="mt-8 text-xs">
            <p><strong>Certified True and Correct:</strong></p>
            <p class="mt-4">___________________________________</p>
            <p>Class Adviser</p>
        </div>

        <div class="mt-6 text-xs">
            <p><strong>Verified by:</strong></p>
            <p class="mt-4">___________________________________</p>
            <p>School Head</p>
        </div>

        <div class="no-print mt-6">
            <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Print</button>
        </div>
    </div>
@endsection
