@extends('layouts.app')

@section('content')
<div class="mb-6">
    <div class="flex items-center space-x-2 text-sm text-gray-500 mb-2">
        <a href="{{ url('/students') }}" class="hover:text-gray-700">Students</a>
        <span>/</span>
        <span class="text-gray-900">Enroll New Student</span>
    </div>
    <h1 class="text-2xl font-bold text-gray-900">Enroll New Student</h1>
    <p class="text-gray-600">Add a new student to your class and generate SF forms</p>
</div>

<div class="max-w-4xl">
    <form class="bg-white rounded-lg shadow border border-gray-200 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Student Information -->
            <div class="md:col-span-2">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Student Information</h3>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Learner Reference Number (LRN) *</label>
                <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="12-digit LRN" maxlength="12">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Student Type *</label>
                <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Select Type</option>
                    <option value="Regular">Regular</option>
                    <option value="Transferee">Transferee</option>
                    <option value="Balik-Aral">Balik-Aral</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter first name">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter last name">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Middle Name</label>
                <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter middle name">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Suffix</label>
                <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">None</option>
                    <option value="Jr.">Jr.</option>
                    <option value="Sr.">Sr.</option>
                    <option value="II">II</option>
                    <option value="III">III</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Birth Date *</label>
                <input type="date" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gender *</label>
                <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Complete Address *</label>
                <textarea class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="3" placeholder="House No., Street, Barangay, City/Municipality, Province"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Contact Number</label>
                <input type="tel" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="09XX-XXX-XXXX">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Assign to Class *</label>
                <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Select Class</option>
                    <option value="1">Grade 7 - Section A</option>
                    <option value="2">Grade 8 - Section B</option>
                    <option value="3">Grade 9 - Section C</option>
                </select>
            </div>

            <!-- Parent/Guardian Information -->
            <div class="md:col-span-2">
                <h3 class="text-lg font-medium text-gray-900 mb-4 mt-6">Parent/Guardian Information</h3>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Parent/Guardian Name *</label>
                <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Full name of parent/guardian">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Parent Contact Number</label>
                <input type="tel" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="09XX-XXX-XXXX">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Relationship</label>
                <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Select Relationship</option>
                    <option value="Father">Father</option>
                    <option value="Mother">Mother</option>
                    <option value="Guardian">Guardian</option>
                    <option value="Grandmother">Grandmother</option>
                    <option value="Grandfather">Grandfather</option>
                    <option value="Aunt">Aunt</option>
                    <option value="Uncle">Uncle</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Parent Occupation</label>
                <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Parent's occupation">
            </div>

            <!-- Academic Information -->
            <div class="md:col-span-2">
                <h3 class="text-lg font-medium text-gray-900 mb-4 mt-6">Academic Information</h3>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Previous School</label>
                <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Name of previous school">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">School Year Enrolled</label>
                <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="2024-2025" selected>2024-2025</option>
                    <option value="2025-2026">2025-2026</option>
                </select>
            </div>

            <!-- Auto-generate Forms -->
            <div class="md:col-span-2">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-blue-900 mb-2">Auto-generate School Forms</h4>
                    <p class="text-sm text-blue-700 mb-3">Upon enrollment, the following forms will be automatically generated:</p>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" checked disabled>
                            <span class="ml-2 text-sm text-blue-700">SF1 - School Register Entry</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" checked disabled>
                            <span class="ml-2 text-sm text-blue-700">SF9 - Report Card Template</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" checked disabled>
                            <span class="ml-2 text-sm text-blue-700">SF10 - Learner's Permanent Academic Record</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="mt-8 flex justify-end space-x-3">
            <a href="{{ url('/students') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg font-medium">
                Cancel
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                Enroll Student
            </button>
        </div>
    </form>
</div>
@endsection