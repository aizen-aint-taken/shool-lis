@extends('layouts.app')

@section('content')
<!-- Success/Error Messages -->
@if(session('success'))
<div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
    {{ session('error') }}
</div>
@endif

<!-- Role-based Access Control -->
@if(auth()->user()->role === 'admin')
<div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6">
    <strong>Administrator Access:</strong> You can edit student information and transfer between classes.
</div>
@elseif(auth()->user()->role === 'adviser')
<div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
    <strong>Adviser Access:</strong> You can edit student information.
</div>
@else
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
    <strong>Access Denied:</strong> Only administrators and advisers can edit students.
</div>
@endif

@if(in_array(auth()->user()->role, ['admin', 'adviser']))

<div class="mb-6">
    <div class="flex items-center space-x-2 text-sm text-gray-500 mb-2">
        <a href="{{ auth()->user()->role === "admin" ? route('admin.students.index') : route('students.index') }}" class="hover:text-gray-700">Students</a>
        <span>/</span>
        <a href="{{ auth()->user()->role === "admin" ? route('admin.students.show', $student) : route('students.show', $student) }}" class="hover:text-gray-700">{{ $student->full_name }}</a>
        <span>/</span>
        <span class="text-gray-900">Edit</span>
    </div>
    <h1 class="text-2xl font-bold text-gray-900">Edit Student Information</h1>
    <p class="text-gray-600">Update student details and class assignment</p>
</div>

<div class="max-w-4xl">
    <form action="{{ auth()->user()->role === "admin" ? route('admin.students.update', $student) : route('students.update', $student) }}" method="POST" class="bg-white rounded-lg shadow border border-gray-200 p-6">
        @csrf
        @method('PUT')
        
        <!-- Class Selection -->
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Class Assignment</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Class *</label>
                    <select name="school_class_id" id="classSelect" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Choose a class...</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ old('school_class_id', $student->school_class_id) == $class->id ? 'selected' : '' }}>
                            Grade {{ $class->grade_level }} - {{ $class->section }} ({{ $class->school_year }}) - 
                            {{ $class->students->where('is_active', true)->count() }}/{{ $class->max_students }} students
                        </option>
                        @endforeach
                    </select>
                    @error('school_class_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LRN (Learner Reference Number) *</label>
                    <input type="text" name="lrn" id="lrn" value="{{ old('lrn', $student->lrn) }}" required maxlength="12" placeholder="123456789012" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('lrn')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $student->first_name) }}" required maxlength="50" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('first_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $student->last_name) }}" required maxlength="50" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('last_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Middle Name</label>
                    <input type="text" name="middle_name" value="{{ old('middle_name', $student->middle_name) }}" maxlength="50" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('middle_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Suffix</label>
                    <input type="text" name="suffix" value="{{ old('suffix', $student->suffix) }}" maxlength="10" placeholder="Jr., Sr., III" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('suffix')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gender *</label>
                    <select name="gender" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Gender</option>
                        <option value="Male" {{ old('gender', $student->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', $student->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Birth Date *</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $student->birth_date) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('birth_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mother Tongue</label>
                    <input type="text" name="mother_tongue" value="{{ old('mother_tongue', $student->mother_tongue) }}" maxlength="50" placeholder="Tagalog, Bisaya, etc." class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('mother_tongue')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Religion</label>
                    <input type="text" name="religion" value="{{ old('religion', $student->religion) }}" maxlength="50" placeholder="Catholic, Protestant, etc." class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('religion')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Complete Address *</label>
                    <textarea name="address" required rows="3" maxlength="200" placeholder="Complete home address" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('address', $student->address) }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Student Contact Number</label>
                    <input type="text" name="contact_number" value="{{ old('contact_number', $student->contact_number) }}" maxlength="15" placeholder="09123456789" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('contact_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Parent/Guardian Information -->
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Parent/Guardian Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Parent/Guardian Name *</label>
                    <input type="text" name="parent_guardian" value="{{ old('parent_guardian', $student->parent_guardian) }}" required maxlength="100" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('parent_guardian')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Parent/Guardian Contact *</label>
                    <input type="text" name="parent_contact" value="{{ old('parent_contact', $student->parent_contact) }}" required maxlength="15" placeholder="09123456789" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('parent_contact')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
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
                        <option value="Regular" {{ old('student_type', $student->student_type) === 'Regular' ? 'selected' : '' }}>Regular</option>
                        <option value="Transferee" {{ old('student_type', $student->student_type) === 'Transferee' ? 'selected' : '' }}>Transferee</option>
                        <option value="Returnee" {{ old('student_type', $student->student_type) === 'Returnee' ? 'selected' : '' }}>Returnee</option>
                        <option value="Balik-Aral" {{ old('student_type', $student->student_type) === 'Balik-Aral' ? 'selected' : '' }}>Balik-Aral</option>
                    </select>
                    @error('student_type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Indigenous People/Ethnic Group</label>
                    <input type="text" name="ethnic_group" value="{{ old('ethnic_group', $student->ethnic_group) }}" maxlength="50" placeholder="Leave blank if not applicable" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('ethnic_group')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Student Status -->
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Student Status</h3>
            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $student->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <label for="is_active" class="ml-2 text-sm text-gray-700">Student is active</label>
            </div>
            <p class="text-gray-500 text-xs mt-1">Inactive students will not appear in class rosters and grade encoding</p>
            @error('is_active')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <a href="{{ auth()->user()->role === "admin" ? route('admin.students.show', $student) : route('students.show', $student) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg text-sm font-medium">
                Cancel
            </a>
            <button type="submit" id="submitBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-medium">
                Update Student
            </button>
        </div>
    </form>
</div>

@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
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

    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const originalText = submitBtn.textContent;
        
        // Disable submit button and show loading state
        submitBtn.disabled = true;
        submitBtn.textContent = 'Updating...';
        
        // Create FormData object
        const formData = new FormData(form);
        
        // Submit via fetch
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                const successDiv = document.createElement('div');
                successDiv.className = 'mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded';
                successDiv.textContent = data.message;
                
                // Insert at top of content
                const content = document.querySelector('.mb-6');
                content.parentNode.insertBefore(successDiv, content);
                
                // Redirect to dashboard page after a short delay
                setTimeout(() => {
                    window.location.href = '{{ auth()->user()->role === "admin" ? route("admin.students.show", $student) : route("students.show", $student) }}';
                }, 1500);
            } else {
                // Show error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded';
                errorDiv.textContent = data.message || 'An error occurred while updating the student.';
                
                // Insert at top of content
                const content = document.querySelector('.mb-6');
                content.parentNode.insertBefore(errorDiv, content);
                
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Show error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded';
            errorDiv.textContent = 'An error occurred while updating the student.';
            
            // Insert at top of content
            const content = document.querySelector('.mb-6');
            content.parentNode.insertBefore(errorDiv, content);
            
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        });
    });
});
</script>

@endsection