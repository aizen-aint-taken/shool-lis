@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Real-time Grade Updates Dashboard</h1>
        <p class="text-gray-600">Monitor grade encoding activities in real-time</p>
        
        <!-- Real-time Status Indicator -->
        <div class="mt-2 flex items-center">
            <div class="flex items-center text-sm text-gray-600">
                <div id="connectionStatus" class="w-2 h-2 bg-gray-400 rounded-full mr-2"></div>
                <span id="realtimeStatus" class="text-xs text-gray-500">Connecting to real-time updates...</span>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Today's Updates</dt>
                        <dd id="todayUpdates" class="text-lg font-medium text-gray-900">0</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Active Teachers</dt>
                        <dd id="activeTeachers" class="text-lg font-medium text-gray-900">0</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 102 0V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 2a1 1 0 000 2h2a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Classes Updated</dt>
                        <dd id="classesUpdated" class="text-lg font-medium text-gray-900">0</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Students Graded</dt>
                        <dd id="studentsGraded" class="text-lg font-medium text-gray-900">0</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Real-time Activity Feed -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Real-time Grade Updates</h3>
            <p class="text-sm text-gray-600">Live feed of grade encoding activities</p>
        </div>
        <div class="p-6">
            <div id="activityFeed" class="space-y-4 max-h-96 overflow-y-auto">
                <div class="text-center text-gray-500 py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="mt-2">Waiting for grade updates...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const userRole = @json(auth()->user()->role);
    let todayUpdates = 0;
    let activeTeachers = new Set();
    let classesUpdated = new Set();
    let studentsGraded = new Set();
    
    // Initialize real-time updates
    initializeRealTimeUpdates();
    
    function initializeRealTimeUpdates() {
        if (userRole === 'admin' || userRole === 'adviser') {
            const eventSource = new EventSource('/grades/updates/stream');
            
            eventSource.onopen = function(event) {
                console.log('Real-time grade updates connected');
                updateConnectionStatus('connected', 'Connected to real-time updates');
            };
            
            eventSource.onmessage = function(event) {
                const data = JSON.parse(event.data);
                handleRealTimeUpdate(data);
            };
            
            eventSource.onerror = function(event) {
                console.error('SSE connection error:', event);
                updateConnectionStatus('error', 'Connection lost. Attempting to reconnect...');
                
                setTimeout(() => {
                    if (eventSource.readyState === EventSource.CLOSED) {
                        initializeRealTimeUpdates();
                    }
                }, 5000);
            };
            
            // Clean up on page unload
            window.addEventListener('beforeunload', function() {
                eventSource.close();
            });
        }
    }
    
    function updateConnectionStatus(status, message) {
        const statusElement = document.getElementById('connectionStatus');
        const messageElement = document.getElementById('realtimeStatus');
        
        if (statusElement && messageElement) {
            if (status === 'connected') {
                statusElement.className = 'w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse';
            } else if (status === 'error') {
                statusElement.className = 'w-2 h-2 bg-red-400 rounded-full mr-2';
            } else {
                statusElement.className = 'w-2 h-2 bg-gray-400 rounded-full mr-2';
            }
            
            messageElement.textContent = message;
        }
    }
    
    function handleRealTimeUpdate(data) {
        if (data.type === 'connected') {
            console.log('Connected as:', data.user, '(' + data.role + ')');
            return;
        }
        
        if (data.type === 'heartbeat') {
            return;
        }
        
        if (data.type === 'grade_updated') {
            addToActivityFeed(data);
            updateStatistics(data);
        }
    }
    
    function addToActivityFeed(data) {
        const feed = document.getElementById('activityFeed');
        const timestamp = new Date(data.timestamp).toLocaleTimeString();
        
        const activityItem = document.createElement('div');
        activityItem.className = 'flex items-start space-x-3 p-3 bg-gray-50 rounded-lg border-l-4 border-blue-500';
        activityItem.style.animation = 'slideInDown 0.3s ease-out';
        
        activityItem.innerHTML = `
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-sm font-medium text-gray-900">
                    Grade Updated: ${data.subject_name}
                </div>
                <div class="text-sm text-gray-600">
                    Student: <span class="font-medium">${data.student_name}</span><br>
                    ${data.grading_period}: <span class="font-bold text-blue-600">${data.score}</span> 
                    <span class="text-xs ${data.remarks === 'PASSED' ? 'text-green-600' : 'text-red-600'}">(${data.remarks})</span><br>
                    Teacher: <span class="font-medium">${data.teacher_name}</span>
                </div>
                <div class="text-xs text-gray-400 mt-1">
                    ${timestamp}
                </div>
            </div>
        `;
        
        // Remove placeholder if it exists
        const placeholder = feed.querySelector('.text-center');
        if (placeholder) {
            placeholder.remove();
        }
        
        // Add to top of feed
        feed.insertBefore(activityItem, feed.firstChild);
        
        // Limit to 10 items (reduced from 20) to improve performance
        const items = feed.querySelectorAll('div[class*="flex items-start"]');
        if (items.length > 10) {
            items[items.length - 1].remove();
        }
    }
    
    function updateStatistics(data) {
        // Update today's updates
        todayUpdates++;
        document.getElementById('todayUpdates').textContent = todayUpdates;
        
        // Track unique active teachers
        activeTeachers.add(data.teacher_name);
        document.getElementById('activeTeachers').textContent = activeTeachers.size;
        
        // Track unique classes updated
        classesUpdated.add(data.school_class_id);
        document.getElementById('classesUpdated').textContent = classesUpdated.size;
        
        // Track unique students graded
        studentsGraded.add(data.student_id);
        document.getElementById('studentsGraded').textContent = studentsGraded.size;
    }
});
</script>

<style>
@keyframes slideInDown {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>
@endsection