@extends('layouts.student')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 px-4 py-3">
        <div class="flex items-center justify-between max-w-7xl mx-auto">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-blue-600 rounded flex items-center justify-center">
                    <span class="text-white font-bold text-sm">DepEd</span>
                </div>
                <span class="text-gray-700 font-medium">Student Portal</span>
            </div>
            <div class="text-right">
                <a href="{{ url('/portal/login') }}" class="text-blue-600 hover:text-blue-800 text-sm">Logout</a>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 py-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">My Grades</h1>
            <p class="text-gray-600">View your academic performance and report card</p>
        </div>

        <!-- Student Information Card -->
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6 mb-6">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                    <span class="text-xl font-bold text-blue-600">JD</span>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Juan Antonio Dela Cruz</h2>
                    <p class="text-gray-600">LRN: 123456789012</p>
                    <p class="text-gray-600">Grade 7 - Section A | School Year: 2024-2025</p>
                </div>
            </div>
        </div>

        <!-- Quarter Selection -->
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Select Quarter</h3>
            <div class="flex space-x-2">
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">1st Quarter</button>
                <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300">2nd Quarter</button>
                <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300">3rd Quarter</button>
                <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300">4th Quarter</button>
            </div>
        </div>

        <!-- Grades Table -->
        <div class="bg-white rounded-lg shadow border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">1st Quarter Grades</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Learning Area</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Written Works<br><span class="text-xs normal-case">(30%)</span></th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Performance Tasks<br><span class="text-xs normal-case">(50%)</span></th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Quarterly Assessment<br><span class="text-xs normal-case">(20%)</span></th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Quarterly Grade</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Mathematics</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">85</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">88</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">82</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">86</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">Passed</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Science</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">90</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">89</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">87</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">88</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">Passed</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">English</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">87</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">85</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">89</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">86</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">Passed</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Filipino</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">88</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">87</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">86</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">87</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">Passed</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Araling Panlipunan</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">91</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">89</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">88</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">89</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">Passed</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Values Education</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">92</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">90</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">89</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">90</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">Passed</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MAPEH</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">93</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">91</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">90</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">91</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">Passed</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">TLE</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">89</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">88</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">87</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">88</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">Passed</td>
                        </tr>
                        <tr class="bg-blue-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">GENERAL AVERAGE</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">-</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">-</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">-</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 text-sm font-bold rounded-full bg-blue-100 text-blue-800">88.1</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-green-600">PASSED</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Performance Summary -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <div class="text-sm font-medium text-gray-500">General Average</div>
                <div class="text-2xl font-bold text-blue-600">88.1</div>
                <div class="text-sm text-green-600">Above Average</div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <div class="text-sm font-medium text-gray-500">Highest Grade</div>
                <div class="text-2xl font-bold text-green-600">91</div>
                <div class="text-sm text-gray-600">MAPEH</div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <div class="text-sm font-medium text-gray-500">Subjects Passed</div>
                <div class="text-2xl font-bold text-purple-600">8/8</div>
                <div class="text-sm text-green-600">All Subjects</div>
            </div>
        </div>

        <!-- Download Options -->
        <div class="mt-6 bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Download Report Card</h3>
            <div class="flex space-x-4">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download SF9 (PDF)
                </button>
             
            </div>
        </div>
    </div>
</div>
@endsection
