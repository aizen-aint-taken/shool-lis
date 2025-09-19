@extends('layouts.app')

@section('content')
<!-- Role-based Access Control -->
@if(auth()->user()->role === 'admin')
<div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6">
    <strong>Administrator Access:</strong> You can enroll students in any class.
</div>
@elseif(auth()->user()->role === 'adviser')
<div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
    <strong>Adviser Access:</strong> You can enroll students in classes.
</div>
@else
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
    <strong>Access Denied:</strong> Only administrators and advisers can enroll students.
</div>
@endif

@if(in_array(auth()->user()->role, ['admin', 'adviser']))

<div class="mb-6">
    <div class="flex items-center space-x-2 text-sm text-gray-500 mb-2">
        <a href="{{ auth()->user()->role === "admin" ? route('admin.classes.index') : route('classes.index') }}" class="hover:text-gray-700">Classes</a>
        <span>/</span>
        <span class="text-gray-900">Enroll Student</span>
    </div>
    <h1 class="text-2xl font-bold text-gray-900">Enroll New Student</h1>
    <p class="text-gray-600">Add a new student and assign them to a class</p>
</div>

<div class="max-w-4xl">
    <form id="studentForm" class="bg-white rounded-lg shadow border border-gray-200 p-6">
        @csrf
        
        <!-- Class Selection -->
        <div class="mb-6">
            <label for="school_class_id" class="block text-sm font-medium text-gray-700 mb-2">Assign to Class *</label>
            <select id="school_class_id" name="school_class_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <option value="">Select a class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ $selectedClassId == $class->id ? 'selected' : '' }}>
                        {{ $class->class_name }} (Grade {{ $class->grade_level }} - {{ $class->section }}) - {{ $class->school_year }}
                    </option>
                @endforeach
            </select>
            <p class="mt-1 text-sm text-gray-500">Select the class to enroll this student in.</p>
        </div>

        <!-- LRN -->
        <div class="mb-6">
            <label for="lrn" class="block text-sm font-medium text-gray-700 mb-2">Learner Reference Number (LRN) *</label>
            <input type="text" id="lrn" name="lrn" value="{{ old('lrn') }}" maxlength="12" 
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                   placeholder="Enter 12-digit LRN">
            <p class="mt-1 text-sm text-gray-500">Unique 12-digit identifier assigned by DepEd.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- First Name -->
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" 
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                       placeholder="Enter first name">
            </div>

            <!-- Middle Name -->
            <div>
                <label for="middle_name" class="block text-sm font-medium text-gray-700 mb-2">Middle Name</label>
                <input type="text" id="middle_name" name="middle_name" value="{{ old('middle_name') }}" 
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                       placeholder="Enter middle name">
            </div>

            <!-- Last Name -->
            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" 
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                       placeholder="Enter last name">
            </div>
        </div>

        <!-- Suffix -->
        <div class="mb-6">
            <label for="suffix" class="block text-sm font-medium text-gray-700 mb-2">Suffix</label>
            <select id="suffix" name="suffix" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <option value="">None</option>
                <option value="Jr." {{ old('suffix') == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                <option value="Sr." {{ old('suffix') == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                <option value="III" {{ old('suffix') == 'III' ? 'selected' : '' }}>III</option>
                <option value="IV" {{ old('suffix') == 'IV' ? 'selected' : '' }}>IV</option>
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Birth Date -->
            <div>
                <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">Birth Date *</label>
                <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" 
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>

            <!-- Gender -->
            <div>
                <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Gender *</label>
                <select id="gender" name="gender" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="">Select gender</option>
                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
        </div>

        <!-- Address -->
        <div class="mb-6">
            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
            <textarea id="address" name="address" rows="2" 
                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                      placeholder="Enter complete address">{{ old('address') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Contact Number -->
            <div>
                <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-2">Student Contact Number</label>
                <input type="text" id="contact_number" name="contact_number" value="{{ old('contact_number') }}" 
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                       placeholder="Enter contact number">
            </div>

            <!-- Student Type -->
            <div>
                <label for="student_type" class="block text-sm font-medium text-gray-700 mb-2">Student Type</label>
                <select id="student_type" name="student_type" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="Regular" {{ old('student_type', 'Regular') == 'Regular' ? 'selected' : '' }}>Regular</option>
                    <option value="Irregular" {{ old('student_type') == 'Irregular' ? 'selected' : '' }}>Irregular</option>
                    <option value="Transferee" {{ old('student_type') == 'Transferee' ? 'selected' : '' }}>Transferee</option>
                </select>
            </div>
        </div>

        <!-- Parent/Guardian Information -->
        <div class="border-t border-gray-200 pt-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Parent/Guardian Information</h3>
            
            <!-- Parent/Guardian Name -->
            <div class="mb-6">
                <label for="parent_guardian" class="block text-sm font-medium text-gray-700 mb-2">Parent/Guardian Name *</label>
                <input type="text" id="parent_guardian" name="parent_guardian" value="{{ old('parent_guardian') }}" 
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                       placeholder="Enter parent or guardian name">
            </div>

            <!-- Parent Contact -->
            <div class="mb-6">
                <label for="parent_contact" class="block text-sm font-medium text-gray-700 mb-2">Parent/Guardian Contact *</label>
                <input type="text" id="parent_contact" name="parent_contact" value="{{ old('parent_contact') }}" 
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                       placeholder="Enter parent or guardian contact number">
            </div>
        </div>

        <!-- Additional Information -->
        <div class="border-t border-gray-200 pt-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Mother Tongue -->
                <div>
                    <label for="mother_tongue" class="block text-sm font-medium text-gray-700 mb-2">Mother Tongue</label>
                    <input type="text" id="mother_tongue" name="mother_tongue" value="{{ old('mother_tongue') }}" 
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                           placeholder="Enter mother tongue">
                </div>

                <!-- Religion -->
                <div>
                    <label for="religion" class="block text-sm font-medium text-gray-700 mb-2">Religion</label>
                    <input type="text" id="religion" name="religion" value="{{ old('religion') }}" 
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                           placeholder="Enter religion">
                </div>

                <!-- Ethnic Group -->
                <div>
                    <label for="ethnic_group" class="block text-sm font-medium text-gray-700 mb-2">Ethnic Group</label>
                    <input type="text" id="ethnic_group" name="ethnic_group" value="{{ old('ethnic_group') }}" 
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                           placeholder="Enter ethnic group">
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <a href="{{ auth()->user()->role === "admin" ? route('admin.classes.index') : route('classes.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg text-sm font-medium">
                Cancel
            </a>
            <button type="submit" id="submitBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-medium">
                Enroll Student
            </button>
        </div>
    </form>
</div>

<!-- Success/Error Messages -->
<div id="messageContainer" class="mt-4" style="display: none;"></div>

@endif

<!-- Add CSRF token meta tag for AJAX requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
// Student enrollment JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('studentForm');
    const submitBtn = document.getElementById('submitBtn');
    
    // Auto-format LRN to 12 digits
    const lrnInput = document.getElementById('lrn');
    lrnInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
        if (value.length > 12) {
            value = value.slice(0, 12); // Limit to 12 digits
        }
        e.target.value = value;
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        enrollStudent();
    });

    function enrollStudent() {
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);

        // Validation
        if (!data.school_class_id) {
            showMessage('Please select a class.', 'error');
            return;
        }

        if (!data.lrn || data.lrn.length !== 12) {
            showMessage('LRN must be exactly 12 digits.', 'error');
            return;
        }

        // Show loading state
        submitBtn.disabled = true;
        submitBtn.textContent = 'Enrolling...';
        submitBtn.classList.add('opacity-50');

        // Use the appropriate route based on user role
        const storeRoute = '{{ auth()->user()->role === 'admin' ? route('admin.students.store') : route('students.store') }}';
        
        fetch(storeRoute, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            // Reset button state
            submitBtn.disabled = false;
            submitBtn.textContent = 'Enroll Student';
            submitBtn.classList.remove('opacity-50');

            if (data.success) {
                showMessage(`✅ Student enrolled successfully! LRN: ${data.student.lrn}`, 'success');
                
                // Reset form after successful enrollment
                setTimeout(() => {
                    form.reset();
                    // Redirect to appropriate index page based on role
                    window.location.href = '{{ auth()->user()->role === 'admin' ? route('admin.students.index') : route('students.index') }}';
                }, 2000);
            } else {
                showMessage('❌ Error: ' + (data.message || 'Failed to enroll student'), 'error');
            }
        })
        .catch(error => {
            // Reset button state on error
            submitBtn.disabled = false;
            submitBtn.textContent = 'Enroll Student';
            submitBtn.classList.remove('opacity-50');
            
            console.error('Error enrolling student:', error);
            showMessage('❌ Error enrolling student: ' + error.message, 'error');
        });
    }

    function showMessage(message, type) {
        const alertClass = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
        document.getElementById('messageContainer').innerHTML = `
            <div class="${alertClass} px-4 py-3 rounded border">
                ${message}
            </div>
        `;
        document.getElementById('messageContainer').style.display = 'block';

        setTimeout(() => {
            document.getElementById('messageContainer').style.display = 'none';
        }, 5000);
    }
});
</script>

@endsection