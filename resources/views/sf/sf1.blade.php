@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School Form 1 (SF1) - School Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body class="p-6 bg-gray-100">
    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-6">

        {{-- Header --}}
        <div class="text-center border-b pb-4 mb-4">
            <h1 class="text-lg font-bold uppercase">School Form 1 (SF1) - School Register</h1>
            <p class="text-sm italic">List of Learners by Class</p>
        </div>

        {{-- School Info --}}
        <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
            <div>
                <p><strong>Region:</strong> Region IV-A</p>
                <p><strong>School ID:</strong> 123456</p>
                <p><strong>School Name:</strong> Sample National High School</p>
            </div>
            <div>
                <p><strong>Division:</strong> Sample Division</p>
                <p><strong>District:</strong> Sample District</p>
                <p><strong>School Year:</strong> 2024–2025</p>
            </div>
        </div>

        {{-- Class Info --}}
        <div class="mb-4 text-sm">
            <p><strong>Grade Level:</strong> Grade 7</p>
            <p><strong>Section:</strong> Section A</p>
            <p><strong>Adviser:</strong> Mr. Juan Dela Cruz</p>
        </div>

        {{-- Learners Table --}}
        <table class="w-full border-collapse border text-xs">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border p-1 w-8">No.</th>
                    <th class="border p-1">LRN</th>
                    <th class="border p-1">Learner’s Name</th>
                    <th class="border p-1">Sex</th>
                    <th class="border p-1">Birthdate</th>
                    <th class="border p-1">Age</th>
                    <th class="border p-1">Mother Tongue</th>
                    <th class="border p-1">IP (Ethnic Group)</th>
                    <th class="border p-1">Religion</th>
                    <th class="border p-1">Address</th>
                    <th class="border p-1">Parent/Guardian</th>
                    <th class="border p-1">Contact No.</th>
                </tr>
            </thead>
            <tbody>
                {{-- Sample Rows --}}
                <tr>
                    <td class="border p-1 text-center">1</td>
                    <td class="border p-1 text-center">123456789012</td>
                    <td class="border p-1">Cruz, Maria Santos</td>
                    <td class="border p-1 text-center">F</td>
                    <td class="border p-1 text-center">2009-03-15</td>
                    <td class="border p-1 text-center">15</td>
                    <td class="border p-1 text-center">Tagalog</td>
                    <td class="border p-1 text-center">---</td>
                    <td class="border p-1 text-center">Catholic</td>
                    <td class="border p-1">Brgy. San Isidro, City</td>
                    <td class="border p-1">Ana Cruz</td>
                    <td class="border p-1 text-center">09123456789</td>
                </tr>
                <tr>
                    <td class="border p-1 text-center">2</td>
                    <td class="border p-1 text-center">987654321098</td>
                    <td class="border p-1">Reyes, Juan D.</td>
                    <td class="border p-1 text-center">M</td>
                    <td class="border p-1 text-center">2008-10-22</td>
                    <td class="border p-1 text-center">16</td>
                    <td class="border p-1 text-center">Tagalog</td>
                    <td class="border p-1 text-center">---</td>
                    <td class="border p-1 text-center">INC</td>
                    <td class="border p-1">Brgy. Mabini, City</td>
                    <td class="border p-1">Pedro Reyes</td>
                    <td class="border p-1 text-center">09987654321</td>
                </tr>
                {{-- Add more rows as needed --}}
            </tbody>
        </table>

        {{-- Footer --}}
        <div class="mt-6 text-sm">
            <p><strong>Prepared by:</strong> _______________________________</p>
            <p class="mt-2"><strong>Checked by:</strong> _______________________________</p>
        </div>

        <div class="no-print mt-6">
            <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Print</button>
        </div>
    </div>
</body>
</html>
@endsection
