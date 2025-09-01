@extends('layouts.app')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">SF2 - Enrollment & Attendance</h1>
            <p class="text-gray-600">Daily Attendance Record of Learners</p>
        </div>
        <div class="flex items-center space-x-4">
            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export Excel
            </button>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print
            </button>
        </div>
    </div>
</div>

<!-- School Information Header -->
<div class="bg-white rounded-lg shadow border border-gray-200 mb-6">
    <div class="p-6">
        <div class="text-center mb-6">
            <h2 class="text-lg font-bold text-gray-900">DAILY ATTENDANCE RECORD OF LEARNERS</h2>
            <p class="text-sm text-gray-600">(To be accomplished by the Class Adviser)</p>
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
                <div class="flex">
                    <span class="font-medium text-gray-700 w-32">Division:</span>
                    <span class="text-gray-900">Division of Quezon</span>
                </div>
                <div class="flex">
                    <span class="font-medium text-gray-700 w-32">Region:</span>
                    <span class="text-gray-900">Region IV-A (CALABARZON)</span>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex">
                    <span class="font-medium text-gray-700 w-32">Grade & Section:</span>
                    <span class="text-gray-900">Grade 7 - Section A</span>
                </div>
                <div class="flex">
                    <span class="font-medium text-gray-700 w-32">School Year:</span>
                    <span class="text-gray-900">2025-2026</span>
                </div>
                <div class="flex">
                    <span class="font-medium text-gray-700 w-32">Class Adviser:</span>
                    <span class="text-gray-900">Maria Santos</span>
                </div>
                <div class="flex">
                    <span class="font-medium text-gray-700 w-32">Month:</span>
                    <select class="border border-gray-300 rounded px-2 py-1 text-sm">
                        <option value="september">September 2025</option>
                        <option value="october">October 2025</option>
                        <option value="november">November 2025</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Attendance Record -->
<div class="bg-white rounded-lg shadow border border-gray-200">
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse border border-gray-400">
                <thead>
                    <tr class="bg-gray-100">
                        <th rowspan="2" class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">No.</th>
                        <th rowspan="2" class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center min-w-48">LEARNER'S NAME<br>(Last Name, First Name, Middle Name)</th>
                        <th rowspan="2" class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">LRN</th>
                        <th rowspan="2" class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">SEX<br>(M/F)</th>
                        <th rowspan="2" class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">DATE OF<br>ENROLLMENT</th>
                        <th colspan="31" class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">DAYS OF THE MONTH</th>
                        <th rowspan="2" class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">TOTAL<br>PRESENT</th>
                        <th rowspan="2" class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">TOTAL<br>ABSENT</th>
                        <th rowspan="2" class="border border-gray-400 px-3 py-2 text-xs font-medium text-gray-700 text-center">REMARKS</th>
                    </tr>
                    <tr class="bg-gray-100">
                        @for($day = 1; $day <= 31; $day++)
                        <th class="border border-gray-400 px-1 py-1 text-xs font-medium text-gray-700 text-center w-6">{{ $day }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample Student 1 -->
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">1</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs">DELA CRUZ, Juan Miguel Santos</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">304866202500001</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">M</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">08/15/2025</td>
                        @for($day = 1; $day <= 31; $day++)
                        <td class="border border-gray-400 px-1 py-1 text-xs text-center">
                            @if($day <= 20)
                                <span class="text-green-600 font-bold">✓</span>
                            @elseif($day == 21)
                                <span class="text-red-600 font-bold">✗</span>
                            @elseif($day <= 30)
                                <span class="text-green-600 font-bold">✓</span>
                            @endif
                        </td>
                        @endfor
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center font-bold">29</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center font-bold">1</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs">Good performance</td>
                    </tr>
                    
                    <!-- Sample Student 2 -->
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">2</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs">SANTOS, Maria Luz Garcia</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">304866202500002</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">F</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">08/15/2025</td>
                        @for($day = 1; $day <= 31; $day++)
                        <td class="border border-gray-400 px-1 py-1 text-xs text-center">
                            @if($day <= 30)
                                <span class="text-green-600 font-bold">✓</span>
                            @endif
                        </td>
                        @endfor
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center font-bold">30</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center font-bold">0</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs">Perfect attendance</td>
                    </tr>
                    
                    <!-- Sample Student 3 -->
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">3</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs">RODRIGUEZ, Ana Marie Cruz</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">304866202500003</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">F</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">08/16/2025</td>
                        @for($day = 1; $day <= 31; $day++)
                        <td class="border border-gray-400 px-1 py-1 text-xs text-center">
                            @if($day <= 15)
                                <span class="text-green-600 font-bold">✓</span>
                            @elseif($day == 16 || $day == 23)
                                <span class="text-red-600 font-bold">✗</span>
                            @elseif($day <= 30)
                                <span class="text-green-600 font-bold">✓</span>
                            @endif
                        </td>
                        @endfor
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center font-bold">28</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center font-bold">2</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs">Excused absences</td>
                    </tr>
                    
                    <!-- Add more rows for additional students -->
                    @for($i = 4; $i <= 42; $i++)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">{{ $i }}</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs">STUDENT{{ $i }}, Name{{ $i }} Middle{{ $i }}</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">30486620250000{{ $i }}</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">{{ $i % 2 == 0 ? 'F' : 'M' }}</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center">08/15/2025</td>
                        @for($day = 1; $day <= 31; $day++)
                        <td class="border border-gray-400 px-1 py-1 text-xs text-center">
                            @if($day <= 30)
                                @if(rand(1, 10) > 1)
                                    <span class="text-green-600 font-bold">✓</span>
                                @else
                                    <span class="text-red-600 font-bold">✗</span>
                                @endif
                            @endif
                        </td>
                        @endfor
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center font-bold">{{ rand(25, 30) }}</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs text-center font-bold">{{ rand(0, 5) }}</td>
                        <td class="border border-gray-400 px-2 py-1 text-xs">Regular</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        
        <!-- Summary Section -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <h4 class="font-semibold text-gray-900">Monthly Summary</h4>
                <div class="text-sm space-y-1">
                    <div class="flex justify-between">
                        <span>Total Enrolled Students:</span>
                        <span class="font-bold">42</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Total School Days:</span>
                        <span class="font-bold">30</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Average Daily Attendance:</span>
                        <span class="font-bold">40.2 (95.7%)</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Perfect Attendance:</span>
                        <span class="font-bold">15 students</span>
                    </div>
                </div>
            </div>
            
            <div class="space-y-2">
                <h4 class="font-semibold text-gray-900">Legend</h4>
                <div class="text-sm space-y-1">
                    <div class="flex items-center space-x-2">
                        <span class="text-green-600 font-bold">✓</span>
                        <span>Present</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-red-600 font-bold">✗</span>
                        <span>Absent</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-yellow-600 font-bold">L</span>
                        <span>Late</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-blue-600 font-bold">E</span>
                        <span>Excused</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Signature Section -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6 border-t border-gray-200 pt-6">
            <div class="text-center">
                <div class="border-b border-gray-400 mb-2 pb-8"></div>
                <p class="text-sm font-medium">Class Adviser</p>
                <p class="text-xs text-gray-600">Maria Santos</p>
            </div>
            <div class="text-center">
                <div class="border-b border-gray-400 mb-2 pb-8"></div>
                <p class="text-sm font-medium">Principal</p>
                <p class="text-xs text-gray-600">Name and Signature</p>
            </div>
            <div class="text-center">
                <div class="border-b border-gray-400 mb-2 pb-8"></div>
                <p class="text-sm font-medium">Date</p>
                <p class="text-xs text-gray-600">{{ date('m/d/Y') }}</p>
            </div>
        </div>
    </div>
</div>

@endsection