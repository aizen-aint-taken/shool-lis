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

<div class="mb-6">
    <div class="flex items-center space-x-2 text-sm text-gray-500 mb-2">
        <a href="{{ auth()->user()->role === "admin" ? route('admin.classes.index') : route('classes.index') }}" class="hover:text-gray-700">Classes</a>
        <span>/</span>
        <span class="text-gray-900">Add New Class</span>
    </div>
    <h1 class="text-2xl font-bold text-gray-900">Add New Class</h1>
    <p class="text-gray-600">Create a new class and assign students</p>
</div>

<div class="max-w-2xl">
    <form action="{{ route('classes.store') }}" method="POST" class="bg-white rounded-lg shadow border border-gray-200 p-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Class Information -->
            <div class="md:col-span-2">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Class Information</h3>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Grade Level *</label>
                <select name="grade_level" id="grade_level" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <option value="">Select Grade Level</option>
                    <option value="7">Grade 7</option>
                    <option value="8">Grade 8</option>
                    <option value="9">Grade 9</option>
                    <option value="10">Grade 10</option>
                    <option value="11">Grade 11</option>
                    <option value="12">Grade 12</option>
                </select>
                @error('grade_level')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Section *</label>
                <input type="text" name="section" id="section" value="{{ old('section') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="e.g. A, B, C, Diamond, etc." required>
                @error('section')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Class Name</label>
                <input type="text" name="class_name" id="class_name" value="{{ old('class_name') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="e.g. Grade 7 - Section A (auto-generated if left empty)">
                @error('class_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-1">Leave empty to auto-generate based on grade level and section</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">School Year *</label>
                <select name="school_year" id="school_year" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <option value="">Select School Year</option>
                    <option value="2024-2025" {{ old('school_year') == '2024-2025' ? 'selected' : '' }}>2024-2025</option>
                    <option value="2025-2026" {{ old('school_year') == '2025-2026' || !old('school_year') ? 'selected' : '' }}>2025-2026</option>
                </select>
                @error('school_year')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Maximum Students *</label>
                <input type="number" name="max_students" id="max_students" value="{{ old('max_students', 45) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" min="10" max="50" required>
                @error('max_students')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Adviser</label>
                <select name="adviser_id" id="adviser_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Select Adviser (Optional)</option>
                    @if(isset($advisers))
                        @foreach($advisers as $adviser)
                            <option value="{{ $adviser->id }}" {{ old('adviser_id') == $adviser->id ? 'selected' : '' }}>{{ $adviser->name }}</option>
                        @endforeach
                    @endif
                </select>
                @error('adviser_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>


        </div>

        <!-- Form Actions -->
        <div class="mt-8 flex justify-end space-x-3">
            <a href="{{ auth()->user()->role === "admin" ? route('admin.classes.index') : route('classes.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg font-medium">
                Cancel
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                Create Class
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const gradeSelect = document.getElementById('grade_level');
    const sectionInput = document.getElementById('section');
    const classNameInput = document.getElementById('class_name');
    
    // Auto-generate class name when grade level or section changes
    function updateClassName() {
        const grade = gradeSelect.value;
        const section = sectionInput.value;
        
        if (grade && section && !classNameInput.value) {
            classNameInput.value = `Grade ${grade} - ${section}`;
        }
    }
    
    gradeSelect.addEventListener('change', updateClassName);
    sectionInput.addEventListener('input', updateClassName);
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        
        // Disable submit button and show loading state
        submitButton.disabled = true;
        submitButton.textContent = 'Creating...';
        
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
                
                // Redirect to classes index after a short delay
                setTimeout(() => {
                    window.location.href = '{{ auth()->user()->role === "admin" ? route("admin.classes.index") : route("classes.index") }}';
                }, 1500);
            } else {
                // Show error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded';
                errorDiv.textContent = data.message || 'An error occurred while creating the class.';
                
                // Insert at top of content
                const content = document.querySelector('.mb-6');
                content.parentNode.insertBefore(errorDiv, content);
                
                // Re-enable submit button
                submitButton.disabled = false;
                submitButton.textContent = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Show error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded';
            errorDiv.textContent = 'An error occurred while creating the class.';
            
            // Insert at top of content
            const content = document.querySelector('.mb-6');
            content.parentNode.insertBefore(errorDiv, content);
            
            // Re-enable submit button
            submitButton.disabled = false;
            submitButton.textContent = originalText;
        });
    });
});
</script>
@endsection
