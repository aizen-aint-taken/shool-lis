@extends('layouts.app')

@section('content')
<div class="mb-6">
    <div class="flex items-center space-x-2 text-sm text-gray-500 mb-2">
        <a href="{{ url('/classes') }}" class="hover:text-gray-700">Classes</a>
        <span>/</span>
        <span class="text-gray-900">Add New Class</span>
    </div>
    <h1 class="text-2xl font-bold text-gray-900">Add New Class</h1>
    <p class="text-gray-600">Create a new class and assign students</p>
</div>

<div class="max-w-2xl">
    <form class="bg-white rounded-lg shadow border border-gray-200 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Class Information -->
            <div class="md:col-span-2">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Class Information</h3>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Grade Level *</label>
                <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Select Grade Level</option>
                    <option value="7">Grade 7</option>
                    <option value="8">Grade 8</option>
                    <option value="9">Grade 9</option>
                    <option value="10">Grade 10</option>
                    <option value="11">Grade 11</option>
                    <option value="12">Grade 12</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Section *</label>
                <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="e.g. A, B, C, Diamond, etc.">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Class Name *</label>
                <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="e.g. Grade 7 - Section A">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">School Year *</label>
                <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Select School Year</option>
                    <option value="2024-2025" selected>2024-2025</option>
                    <option value="2025-2026">2025-2026</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Maximum Students</label>
                <input type="number" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="45" min="1" max="60">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Room/Building</label>
                <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="e.g. Room 101, Building A">
            </div>

            <!-- Subjects -->
            <div class="md:col-span-2">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Subjects to Teach</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Mathematics</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Science</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">English</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Filipino</span>
                        </label>
                    </div>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Araling Panlipunan</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Values Education</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">MAPEH</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">TLE</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Schedule -->
            <div class="md:col-span-2">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Class Schedule</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Time</label>
                        <input type="time" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="07:30">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">End Time</label>
                        <input type="time" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="16:30">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Days</label>
                        <div class="flex flex-wrap gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" checked>
                                <span class="ml-1 text-sm text-gray-700">Mon</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" checked>
                                <span class="ml-1 text-sm text-gray-700">Tue</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" checked>
                                <span class="ml-1 text-sm text-gray-700">Wed</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" checked>
                                <span class="ml-1 text-sm text-gray-700">Thu</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" checked>
                                <span class="ml-1 text-sm text-gray-700">Fri</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="mt-8 flex justify-end space-x-3">
            <a href="{{ url('/classes') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg font-medium">
                Cancel
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                Create Class
            </button>
        </div>
    </form>
</div>
@endsection
