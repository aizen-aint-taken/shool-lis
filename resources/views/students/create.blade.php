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
        <a href="{{ route('classes.index') }}" class="hover:text-gray-700">Classes</a>
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
            <h3 class="text-lg font-medium text-gray-900 mb-4">Class Assignment</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Class *</label>
                    <select name="school_class_id" id="classSelect" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Choose a class...</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $selectedClassId == $class->id ? 'selected' : '' }}>
                            Grade {{ $class->grade_level }} - {{ $class->section }} ({{ $class->school_year }}) - 
                            {{ $class->students->where('is_active', true)->count() }}/{{ $class->max_students }} students
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LRN (Learner Reference Number) *</label>
                    <input type="text" name="lrn" id="lrn" required maxlength="12" placeholder="123456789012" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                    <input type="text" name="first_name" required maxlength="50" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                    <input type="text" name="last_name" required maxlength="50" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Middle Name</label>
                    <input type="text" name="middle_name" maxlength="50" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Suffix</label>
                    <input type="text" name="suffix" maxlength="10" placeholder="Jr., Sr., III" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gender *</label>
                    <select name="gender" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Birth Date *</label>
                    <input type="date" name="birth_date" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mother Tongue</label>
                    <input type="text" name="mother_tongue" maxlength="50" placeholder="Tagalog, Bisaya, etc." class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Religion</label>
                    <input type="text" name="religion" maxlength="50" placeholder="Catholic, Protestant, etc." class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Complete Address *</label>
                    <textarea name="address" required rows="3" maxlength="200" placeholder="Complete home address" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Student Contact Number</label>
                    <input type="text" name="contact_number" maxlength="15" placeholder="09123456789" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
        </div>

        <!-- Parent/Guardian Information -->
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Parent/Guardian Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Parent/Guardian Name *</label>
                    <input type="text" name="parent_guardian" required maxlength="100" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Parent/Guardian Contact *</label>
                    <input type="text" name="parent_contact" required maxlength="15" placeholder="09123456789" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Student Type</label>
                    <select name="student_type" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="Regular">Regular</option>
                        <option value="Transferee">Transferee</option>
                        <option value="Returnee">Returnee</option>
                        <option value="Balik-Aral">Balik-Aral</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Indigenous People/Ethnic Group</label>
                    <input type="text" name="ethnic_group" maxlength="50" placeholder="Leave blank if not applicable" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <a href="{{ route('classes.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg text-sm font-medium">
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

        fetch('/students', {
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
                    window.location.href = data.redirect || '/classes';
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