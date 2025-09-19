@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit User</h1>
                    <p class="text-gray-600">Update information for {{ $user->name }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/admin/users/{{ $user->id }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        View User
                    </a>
                    <a href="/admin/users" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                        Back to Users
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Edit User Form -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">User Information</h3>
                <p class="text-sm text-gray-600">Update the user's basic information and role</p>
            </div>
            
            <form id="editUserForm" class="px-6 py-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ $user->name }}" 
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               required>
                        <div id="nameError" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    
                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="username" name="username" value="{{ $user->username }}" 
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               required>
                        <div id="usernameError" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ $user->email }}" 
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               required>
                        <div id="emailError" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    
                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select id="role" name="role" 
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                required>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="adviser" {{ $user->role === 'adviser' ? 'selected' : '' }}>Adviser</option>
                            <option value="teacher" {{ $user->role === 'teacher' ? 'selected' : '' }}>Teacher</option>
                            <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student</option>
                        </select>
                        <div id="roleError" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                </div>
                
                <!-- Password Section -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Change Password</h4>
                    <p class="text-sm text-gray-600 mb-4">Leave password fields empty to keep current password</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                New Password
                            </label>
                            <input type="password" id="password" name="password" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                   minlength="6">
                            <div id="passwordError" class="text-red-500 text-sm mt-1 hidden"></div>
                            <p class="text-xs text-gray-500 mt-1">Minimum 6 characters</p>
                        </div>
                        
                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirm New Password
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <div id="passwordConfirmationError" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between">
                    <div class="flex space-x-3">
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update User
                        </button>
                        
                        <a href="/admin/users/{{ $user->id }}" 
                           class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg inline-flex items-center">
                            Cancel
                        </a>
                    </div>
                    
                    @if($user->id !== auth()->id())
                    <button type="button" onclick="deleteUser({{ $user->id }})" 
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete User
                    </button>
                    @endif
                </div>
            </form>
        </div>
        
        <!-- User Stats Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden mt-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Account Information</h3>
            </div>
            
            <div class="px-6 py-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900">{{ $user->id }}</div>
                        <div class="text-sm text-gray-600">User ID</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900">{{ $user->created_at->format('M Y') }}</div>
                        <div class="text-sm text-gray-600">Member Since</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">Active</div>
                        <div class="text-sm text-gray-600">Account Status</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Message -->
<div id="messageContainer" class="fixed top-4 right-4 z-50" style="display: none;"></div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Handle edit user form submission
    document.getElementById('editUserForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        clearErrors();
        
        // Get form data
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        
        // Validate passwords match if provided
        if (data.password && data.password !== data.password_confirmation) {
            showFieldError('password_confirmation', 'Passwords do not match');
            return;
        }
        
        // Remove empty password fields to maintain current password
        if (!data.password) {
            delete data.password;
            delete data.password_confirmation;
        }
        
        // Submit form
        fetch(`/admin/users/{{ $user->id }}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage(data.message, 'success');
                // Optionally redirect to user details page
                setTimeout(() => {
                    window.location.href = '/admin/users/{{ $user->id }}';
                }, 2000);
            } else {
                if (data.errors) {
                    // Show validation errors
                    Object.keys(data.errors).forEach(field => {
                        showFieldError(field, data.errors[field][0]);
                    });
                } else {
                    showMessage(data.message || 'Error updating user', 'error');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('An error occurred while updating the user', 'error');
        });
    });
    
    // Delete user functionality
    window.deleteUser = function(userId) {
        if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
            fetch(`/admin/users/${userId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(data.message, 'success');
                    // Redirect to users list after successful deletion
                    setTimeout(() => {
                        window.location.href = '/admin/users';
                    }, 2000);
                } else {
                    showMessage(data.message || 'Error deleting user', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('An error occurred while deleting the user', 'error');
            });
        }
    };
    
    // Clear all error messages
    function clearErrors() {
        const errorElements = document.querySelectorAll('[id$="Error"]');
        errorElements.forEach(element => {
            element.textContent = '';
            element.classList.add('hidden');
        });
        
        // Remove error styling from inputs
        const inputs = document.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.classList.remove('border-red-500');
        });
    }
    
    // Show field-specific error
    function showFieldError(field, message) {
        const errorElement = document.getElementById(field + 'Error');
        const inputElement = document.getElementById(field);
        
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
        }
        
        if (inputElement) {
            inputElement.classList.add('border-red-500');
        }
    }
    
    // Show general message
    function showMessage(message, type) {
        const container = document.getElementById('messageContainer');
        const messageClass = type === 'success' ? 'bg-green-500' : 'bg-red-500';
        
        container.innerHTML = `
            <div class="${messageClass} text-white px-6 py-4 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        `;
        
        container.style.display = 'block';
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            if (container.firstElementChild) {
                container.firstElementChild.remove();
            }
            if (container.children.length === 0) {
                container.style.display = 'none';
            }
        }, 5000);
    }
    
    // Real-time password confirmation validation
    const passwordField = document.getElementById('password');
    const confirmField = document.getElementById('password_confirmation');
    
    confirmField.addEventListener('input', function() {
        if (passwordField.value && this.value && passwordField.value !== this.value) {
            showFieldError('password_confirmation', 'Passwords do not match');
        } else {
            const errorElement = document.getElementById('password_confirmationError');
            if (errorElement) {
                errorElement.textContent = '';
                errorElement.classList.add('hidden');
                this.classList.remove('border-red-500');
            }
        }
    });
});
</script>
@endsection