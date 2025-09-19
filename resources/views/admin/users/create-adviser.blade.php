@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Create New Adviser</h1>
                    <p class="text-gray-600">Create login credentials for a new adviser</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/admin/users" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                        Back to Users
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Create Adviser Form -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Adviser Information</h3>
                <p class="text-sm text-gray-600">Fill out the details below to create a new adviser account</p>
            </div>
            
            <form id="createAdviserForm" class="p-6 space-y-6">
                @csrf
                
                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Enter adviser's full name"
                           required>
                    <p class="text-xs text-gray-500 mt-1">This will be displayed in the system</p>
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="adviser_username"
                           required>
                    <p class="text-xs text-gray-500 mt-1">Used for login (letters, numbers, underscore only)</p>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="adviser@school.edu.ph"
                           required>
                    <p class="text-xs text-gray-500 mt-1">Must be a valid email address</p>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="w-full border border-gray-300 rounded-md px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Minimum 6 characters"
                               required>
                        <button type="button" 
                                onclick="togglePassword('password')" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Minimum 6 characters required</p>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="w-full border border-gray-300 rounded-md px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Re-enter password"
                               required>
                        <button type="button" 
                                onclick="togglePassword('password_confirmation')" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Optional Fields -->
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Additional Information (Optional)</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Employee ID -->
                        <div>
                            <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-2">Employee ID</label>
                            <input type="text" 
                                   id="employee_id" 
                                   name="employee_id" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="EMP001">
                        </div>

                        <!-- Position -->
                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Position</label>
                            <input type="text" 
                                   id="position" 
                                   name="position" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Class Adviser">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="department" class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                        <input type="text" 
                               id="department" 
                               name="department" 
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Junior High School">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <button type="button" 
                            onclick="window.location.href='/admin/users'" 
                            class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancel
                    </button>
                    <button type="submit" 
                            id="submitBtn"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Create Adviser Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Adviser Created Successfully!</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500 mb-4" id="successMessage">The adviser account has been created.</p>
                <div class="bg-gray-50 rounded-lg p-4 text-left">
                    <h4 class="font-medium text-gray-900 mb-2">Login Credentials:</h4>
                    <div class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Username:</span>
                            <span class="font-mono" id="credentialUsername">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Password:</span>
                            <span class="font-mono" id="credentialPassword">-</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Please provide these credentials to the adviser.</p>
                </div>
            </div>
            <div class="items-center px-4 py-3">
                <button onclick="closeSuccessModal()" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Error Message -->
<div id="errorContainer" class="fixed top-4 right-4 z-50" style="display: none;"></div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('createAdviserForm');
    const submitBtn = document.getElementById('submitBtn');
    
    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate passwords match
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirmation').value;
        
        if (password !== passwordConfirm) {
            showError('Passwords do not match!');
            return;
        }
        
        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.textContent = 'Creating Account...';
        
        // Prepare form data
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        // Submit form
        fetch('/admin/advisers', {
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
            if (data.success) {
                // Show success modal with credentials
                document.getElementById('successMessage').textContent = data.message;
                document.getElementById('credentialUsername').textContent = data.credentials.username;
                document.getElementById('credentialPassword').textContent = data.credentials.password;
                document.getElementById('successModal').classList.remove('hidden');
            } else {
                showError(data.message || 'Error creating adviser account');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Error creating adviser account');
        })
        .finally(() => {
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.textContent = 'Create Adviser Account';
        });
    });
    
    // Username validation
    document.getElementById('username').addEventListener('input', function(e) {
        // Remove invalid characters
        e.target.value = e.target.value.replace(/[^a-zA-Z0-9_]/g, '');
    });
    
    // Password toggle function
    window.togglePassword = function(inputId) {
        const input = document.getElementById(inputId);
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
    };
    
    // Close success modal
    window.closeSuccessModal = function() {
        document.getElementById('successModal').classList.add('hidden');
        // Redirect to users page after closing modal
        setTimeout(() => {
            window.location.href = '/admin/users';
        }, 500);
    };
    
    function showError(message) {
        document.getElementById('errorContainer').innerHTML = `
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg">
                ${message}
            </div>
        `;
        document.getElementById('errorContainer').style.display = 'block';

        setTimeout(() => {
            document.getElementById('errorContainer').style.display = 'none';
        }, 5000);
    }
});
</script>
@endsection