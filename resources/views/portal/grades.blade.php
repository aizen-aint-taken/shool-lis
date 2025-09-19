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
                <a href="{{ route('logout') }}" class="text-blue-600 hover:text-blue-800 text-sm"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
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
                    <span class="text-xl font-bold text-blue-600">
                        {{ substr(Auth::user()->name, 0, 2) }}
                    </span>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">{{ Auth::user()->name }}</h2>
                    @if(isset($student))
                    <p class="text-gray-600">LRN: {{ $student->lrn }}</p>
                    <p class="text-gray-600">
                        @if($student->schoolClass)
                            Grade {{ $student->schoolClass->grade_level }} - Section {{ $student->schoolClass->section }} | 
                        @endif
                        School Year: 2025-2026
                    </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quarter Selection -->
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Select Quarter</h3>
            <div class="flex space-x-2">
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm quarter-btn active" data-quarter="1st Quarter">1st Quarter</button>
                <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300 quarter-btn" data-quarter="2nd Quarter">2nd Quarter</button>
                <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300 quarter-btn" data-quarter="3rd Quarter">3rd Quarter</button>
                <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300 quarter-btn" data-quarter="4th Quarter">4th Quarter</button>
            </div>
        </div>

        <!-- Grades Table -->
        <div class="bg-white rounded-lg shadow border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 quarter-title">1st Quarter Grades</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Learning Area</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Quarterly Grade</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 grades-body">
                        @if(isset($grades) && $grades->count() > 0)
                            @foreach($grades as $grade)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $grade->subject->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 py-1 text-sm font-semibold rounded-full 
                                        @if($grade->final_rating >= 75) bg-green-100 text-green-800 
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ number_format($grade->final_rating, 0) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm 
                                    @if($grade->final_rating >= 75) text-green-600 @else text-red-600 @endif">
                                    {{ $grade->remarks }}
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No grades available for this quarter.
                                </td>
                            </tr>
                        @endif
                        @if(isset($grades) && $grades->count() > 0)
                        <tr class="bg-blue-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">GENERAL AVERAGE</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 text-sm font-bold rounded-full bg-blue-100 text-blue-800">
                                    {{ number_format($grades->avg('final_rating'), 1) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold 
                                @if($grades->avg('final_rating') >= 75) text-green-600 
                                @else text-red-600 @endif">
                                @if($grades->avg('final_rating') >= 75) PASSED @else FAILED @endif
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Performance Summary -->
        @if(isset($grades) && $grades->count() > 0)
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6 performance-summary">
            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <div class="text-sm font-medium text-gray-500">General Average</div>
                <div class="text-2xl font-bold text-blue-600">
                    {{ number_format($grades->avg('final_rating'), 1) }}
                </div>
                <div class="text-sm 
                    @if($grades->avg('final_rating') >= 85) text-green-600 
                    @elseif($grades->avg('final_rating') >= 75) text-blue-600 
                    @else text-red-600 @endif">
                    @if($grades->avg('final_rating') >= 85) Outstanding
                    @elseif($grades->avg('final_rating') >= 80) Very Satisfactory
                    @elseif($grades->avg('final_rating') >= 75) Satisfactory
                    @else Needs Improvement @endif
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <div class="text-sm font-medium text-gray-500">Highest Grade</div>
                <div class="text-2xl font-bold text-green-600">
                    {{ number_format($grades->max('final_rating'), 0) }}
                </div>
                <div class="text-sm text-gray-600">
                    {{ $grades->where('final_rating', $grades->max('final_rating'))->first()->subject->name ?? 'N/A' }}
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <div class="text-sm font-medium text-gray-500">Subjects Passed</div>
                <div class="text-2xl font-bold text-purple-600">
                    {{ $grades->where('final_rating', '>=', 75)->count() }}/{{ $grades->count() }}
                </div>
                <div class="text-sm text-green-600">
                    {{ number_format(($grades->where('final_rating', '>=', 75)->count() / $grades->count()) * 100, 0) }}% Passed
                </div>
            </div>
        </div>
        @endif

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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quarterButtons = document.querySelectorAll('.quarter-btn');
        const tableHeader = document.querySelector('.quarter-title');
        const gradesBody = document.querySelector('.grades-body');
        
        quarterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Update button styles
                quarterButtons.forEach(btn => {
                    btn.classList.remove('bg-blue-600', 'text-white');
                    btn.classList.add('bg-gray-200', 'text-gray-700');
                });
                this.classList.remove('bg-gray-200', 'text-gray-700');
                this.classList.add('bg-blue-600', 'text-white');
                
                // Update table title
                const quarter = this.getAttribute('data-quarter');
                tableHeader.textContent = quarter + ' Grades';
                
                // Fetch grades for the selected quarter
                fetchGradesForQuarter(quarter);
            });
        });
        
        function fetchGradesForQuarter(quarter) {
            // Show loading state
            gradesBody.innerHTML = '<tr><td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Loading grades...</td></tr>';
            
            // Make AJAX request to get grades for the selected quarter
            fetch(`/portal/grades?quarter=${encodeURIComponent(quarter)}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Update the grades table
                updateGradesTable(data.grades);
                
                // Update the performance summary
                updatePerformanceSummary(data.summary);
            })
            .catch(error => {
                console.error('Error fetching grades:', error);
                gradesBody.innerHTML = '<tr><td colspan="3" class="px-6 py-4 text-center text-sm text-red-500">Error loading grades. Please try again.</td></tr>';
            });
        }
        
        function updateGradesTable(grades) {
            if (!grades || grades.length === 0) {
                gradesBody.innerHTML = '<tr><td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">No grades available for this quarter.</td></tr>';
                return;
            }
            
            let html = '';
            grades.forEach(grade => {
                const passedClass = grade.passed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                const remarksClass = grade.passed ? 'text-green-600' : 'text-red-600';
                
                html += `
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${grade.subject}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="px-2 py-1 text-sm font-semibold rounded-full ${passedClass}">
                            ${Math.round(grade.final_rating)}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm ${remarksClass}">
                        ${grade.remarks}
                    </td>
                </tr>`;
            });
            
            // Add general average row
            const generalAverage = grades.reduce((sum, grade) => sum + grade.final_rating, 0) / grades.length;
            const avgPassedClass = generalAverage >= 75 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
            const avgRemarksClass = generalAverage >= 75 ? 'text-green-600' : 'text-red-600';
            const avgRemarks = generalAverage >= 75 ? 'PASSED' : 'FAILED';
            
            html += `
            <tr class="bg-blue-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">GENERAL AVERAGE</td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <span class="px-3 py-1 text-sm font-bold rounded-full bg-blue-100 text-blue-800">
                        ${generalAverage.toFixed(1)}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold ${avgRemarksClass}">
                    ${avgRemarks}
                </td>
            </tr>`;
            
            gradesBody.innerHTML = html;
        }
        
        function updatePerformanceSummary(summary) {
            // Remove existing summary
            const existingSummary = document.querySelector('.performance-summary');
            if (existingSummary) {
                existingSummary.remove();
            }
            
            // Create performance summary section
            const container = document.querySelector('.max-w-6xl.mx-auto.px-4.py-6');
            const gradesTable = document.querySelector('.bg-white.rounded-lg.shadow.border.border-gray-200');
            const summaryContainer = document.createElement('div');
            summaryContainer.className = 'mt-6 grid grid-cols-1 md:grid-cols-3 gap-6 performance-summary';
            
            // Determine performance text color
            let performanceClass = 'text-red-600';
            if (summary.general_average >= 85) {
                performanceClass = 'text-green-600';
            } else if (summary.general_average >= 75) {
                performanceClass = 'text-blue-600';
            }
            
            // Determine performance text
            let performanceText = 'Needs Improvement';
            if (summary.general_average >= 85) {
                performanceText = 'Outstanding';
            } else if (summary.general_average >= 80) {
                performanceText = 'Very Satisfactory';
            } else if (summary.general_average >= 75) {
                performanceText = 'Satisfactory';
            }
            
            summaryContainer.innerHTML = `
            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <div class="text-sm font-medium text-gray-500">General Average</div>
                <div class="text-2xl font-bold text-blue-600">
                    ${summary.general_average.toFixed(1)}
                </div>
                <div class="text-sm ${performanceClass}">
                    ${performanceText}
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <div class="text-sm font-medium text-gray-500">Highest Grade</div>
                <div class="text-2xl font-bold text-green-600">
                    ${Math.round(summary.highest_grade)}
                </div>
                <div class="text-sm text-gray-600">
                    ${summary.highest_grade_subject}
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <div class="text-sm font-medium text-gray-500">Subjects Passed</div>
                <div class="text-2xl font-bold text-purple-600">
                    ${summary.subjects_passed}/${summary.total_subjects}
                </div>
                <div class="text-sm text-green-600">
                    ${Math.round(summary.pass_rate)}% Passed
                </div>
            </div>`;
            
            container.insertBefore(summaryContainer, gradesTable.nextSibling);
        }
        
        // Load initial grades for the first quarter
        fetchGradesForQuarter('1st Quarter');
    });
</script>
@endsection