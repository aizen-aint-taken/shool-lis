@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">User Details</h1>
                    <p class="text-gray-600">View detailed information about {{ $user->name }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/admin/users/{{ $user->id }}/edit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit User
                    </a>
                    <a href="/admin/users" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                        Back to Users
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- User Information Card -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">User Information</h3>
                    </div>
                    
                    <div class="px-6 py-6">
                        <div class="flex items-center mb-6">
                            <div class="flex-shrink-0 h-20 w-20">
                                <div class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-2xl font-medium text-gray-700">{{ substr($user->name, 0, 2) }}</span>
                                </div>
                            </div>
                            <div class="ml-6">
                                <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mt-2
                                    @if($user->role === 'admin') bg-red-100 text-red-800
                                    @elseif($user->role === 'adviser') bg-blue-100 text-blue-800
                                    @elseif($user->role === 'teacher') bg-purple-100 text-purple-800
                                    @elseif($user->role === 'student') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">User ID</label>
                                <p class="text-sm text-gray-900">{{ $user->id }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                <p class="text-sm text-gray-900">{{ $user->username }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <p class="text-sm text-gray-900">{{ $user->email }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                <p class="text-sm text-gray-900">{{ ucfirst($user->role) }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Account Created</label>
                                <p class="text-sm text-gray-900">{{ $user->created_at->format('F d, Y \a\t g:i A') }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Updated</label>
                                <p class="text-sm text-gray-900">{{ $user->updated_at->format('F d, Y \a\t g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Activity Section -->
                <div class="bg-white shadow rounded-lg overflow-hidden mt-8">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Recent Activity</h3>
                    </div>
                    
                    <div class="px-6 py-6">
                        <div class="text-center text-gray-500 py-8">
                            <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-lg font-medium">No recent activity</p>
                            <p class="text-sm">Activity tracking will be implemented in future updates.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Quick Actions Card -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                    </div>
                    
                    <div class="px-6 py-6 space-y-4">
                        <a href="/admin/users/{{ $user->id }}/edit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg inline-flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit User
                        </a>
                        
                        @if($user->id !== auth()->id())
                        <button onclick="resetPassword({{ $user->id }})" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg inline-flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                            Reset Password
                        </button>
                        
                        <button onclick="deleteUser({{ $user->id }})" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg inline-flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete User
                        </button>
                        @endif
                    </div>
                </div>
                
                <!-- Additional Info Card -->
                @if($user->role === 'adviser' && $user->advisedClasses && $user->advisedClasses->count() > 0)
                <div class="bg-white shadow rounded-lg overflow-hidden mt-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Advised Classes</h3>
                    </div>
                    
                    <div class="px-6 py-6">
                        <div class="space-y-3">
                            @foreach($user->advisedClasses as $class)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $class->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $class->students_count ?? 0 }} students</p>
                                </div>
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    @if($class->is_active) bg-green-100 text-green-800 
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $class->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- System Info Card -->
                <div class="bg-white shadow rounded-lg overflow-hidden mt-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">System Information</h3>
                    </div>
                    
                    <div class="px-6 py-6 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Account Status:</span>
                            <span class="text-sm font-medium text-green-600">Active</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Email Verified:</span>
                            <span class="text-sm font-medium text-green-600">Yes</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Two Factor:</span>
                            <span class="text-sm font-medium text-gray-600">Disabled</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reset Password Modal -->
<div id="resetPasswordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Reset Password</h3>
            <form id="resetPasswordForm">
                @csrf
                <input type="hidden" id="resetUserId" name="user_id" value="{{ $user->id }}">
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <input type="password" id="resetPassword" name="password" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <input type="password" id="resetPasswordConfirm" name="password_confirmation" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="flex space-x-3">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Reset Password
                    </button>
                    <button type="button" onclick="closeResetModal()" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success/Error Message -->
<div id="messageContainer" class="fixed top-4 right-4 z-50" style="display: none;"></div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reset password functionality
    window.resetPassword = function(userId) {
        document.getElementById('resetPasswordModal').classList.remove('hidden');
    };
    
    window.closeResetModal = function() {
        document.getElementById('resetPasswordModal').classList.add('hidden');
        document.getElementById('resetPasswordForm').reset();
    };
    
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
    
    // Handle reset password form submission
    document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const userId = document.getElementById('resetUserId').value;
        const password = document.getElementById('resetPassword').value;
        const passwordConfirm = document.getElementById('resetPasswordConfirm').value;
        
        if (password !== passwordConfirm) {
            showMessage('Passwords do not match!', 'error');
            return;
        }
        
        fetch(`/admin/users/${userId}/reset-password`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                password: password,
                password_confirmation: passwordConfirm
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage(data.message, 'success');
                closeResetModal();
            } else {
                showMessage(data.message || 'Error resetting password', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('An error occurred while resetting password', 'error');
        });
    });
    
    // Show message function
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
});
</script>
@endsection