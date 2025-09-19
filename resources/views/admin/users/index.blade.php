@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">User Management</h1>
                    <p class="text-gray-600">Manage system users and their roles</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/admin/advisers/create" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Create Adviser
                    </a>
                    <a href="/admin/dashboard" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
    <br>
    
    <!-- Search and Filter Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        <div class="bg-white shadow rounded-lg p-6">
            <form method="GET" action="{{ route('admin.users') }}" class="flex flex-col lg:flex-row gap-4">
                <!-- Search Input -->
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Users</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="search" id="search" name="search" value="{{ request('search') }}" 
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500" 
                               placeholder="Search by name, username, or email...">
                    </div>
                </div>
                
                <!-- Role Filter -->
                <div class="lg:w-48">
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Filter by Role</label>
                    <select id="role" name="role" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="adviser" {{ request('role') == 'adviser' ? 'selected' : '' }}>Adviser</option>
                        <option value="teacher" {{ request('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                        <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Student</option>
                    </select>
                </div>
                
                <!-- Sort By -->
                <div class="lg:w-48">
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                    <select id="sort" name="sort" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="name_asc" {{ request('sort', 'created_desc') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                        <option value="name_desc" {{ request('sort', 'created_desc') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                        <option value="role_asc" {{ request('sort', 'created_desc') == 'role_asc' ? 'selected' : '' }}>Role (A-Z)</option>
                        <option value="role_desc" {{ request('sort', 'created_desc') == 'role_desc' ? 'selected' : '' }}>Role (Z-A)</option>
                        <option value="created_desc" {{ request('sort', 'created_desc') == 'created_desc' ? 'selected' : '' }}>Newest First</option>
                        <option value="created_asc" {{ request('sort', 'created_desc') == 'created_asc' ? 'selected' : '' }}>Oldest First</option>
                        <option value="email_asc" {{ request('sort', 'created_desc') == 'email_asc' ? 'selected' : '' }}>Email (A-Z)</option>
                        <option value="email_desc" {{ request('sort', 'created_desc') == 'email_desc' ? 'selected' : '' }}>Email (Z-A)</option>
                    </select>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-end space-x-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium">
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.users') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md font-medium">
                        Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Users Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">All Users</h3>
                        <p class="text-sm text-gray-600">
                            @if(request('search') || request('role'))
                                Showing {{ $users->total() }} of {{ $users->total() }} users
                                @if(request('search'))
                                    for "{{ request('search') }}"
                                @endif
                                @if(request('role'))
                                    with role "{{ ucfirst(request('role')) }}"
                                @endif
                            @else
                                Total: {{ $users->total() }} users
                            @endif
                        </p>
                    </div>
                    @if(request('search') || request('role') || request('sort'))
                    <div class="text-sm text-gray-500">
                        <a href="{{ route('admin.users') }}" class="text-blue-600 hover:text-blue-800">
                            Clear all filters
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <button type="button" onclick="sortTable('name')" class="flex items-center hover:text-gray-700">
                                    User
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                    </svg>
                                </button>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <button type="button" onclick="sortTable('role')" class="flex items-center hover:text-gray-700">
                                    Role
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                    </svg>
                                </button>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <button type="button" onclick="sortTable('username')" class="flex items-center hover:text-gray-700">
                                    Username
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                    </svg>
                                </button>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <button type="button" onclick="sortTable('email')" class="flex items-center hover:text-gray-700">
                                    Email
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                    </svg>
                                </button>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <button type="button" onclick="sortTable('created')" class="flex items-center hover:text-gray-700">
                                    Created
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                    </svg>
                                </button>
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-700">{{ substr($user->name, 0, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">ID: {{ $user->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($user->role === 'admin') bg-red-100 text-red-800
                                    @elseif($user->role === 'adviser') bg-blue-100 text-blue-800
                                    @elseif($user->role === 'teacher') bg-purple-100 text-purple-800
                                    @elseif($user->role === 'student') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                           
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->username }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="/admin/users/{{ $user->id }}" class="text-blue-600 hover:text-blue-900" title="View Details">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="/admin/users/{{ $user->id }}/edit" class="text-yellow-600 hover:text-yellow-900" title="Edit User">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    @if($user->id !== auth()->id())
                                    <button onclick="resetPassword({{ $user->id }})" class="text-purple-600 hover:text-purple-900" title="Reset Password">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                        </svg>
                                    </button>
                                    <button onclick="deleteUser({{ $user->id }})" class="text-red-600 hover:text-red-900" title="Delete User">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="text-lg font-medium">No users found</p>
                                <p class="text-sm">Create your first adviser account to get started.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $users->links() }}
            </div>
            @endif
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
                <input type="hidden" id="resetUserId" name="user_id">
                
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

<style>
.sort-active {
    color: #2563eb;
    font-weight: 600;
}

.sort-asc::after {
    content: ' ↑';
    font-weight: bold;
}

.sort-desc::after {
    content: ' ↓';
    font-weight: bold;
}

.table-hover-row:hover {
    background-color: #f9fafb;
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.search-highlight {
    background-color: #fef3c7;
    padding: 2px 4px;
    border-radius: 3px;
}
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Table sorting functionality with visual feedback
    window.sortTable = function(column) {
        const currentSort = new URLSearchParams(window.location.search).get('sort');
        let newSort;
        
        // Determine new sort direction
        if (currentSort === column + '_asc') {
            newSort = column + '_desc';
        } else {
            newSort = column + '_asc';
        }
        
        // Update URL with new sort parameter
        const url = new URL(window.location);
        url.searchParams.set('sort', newSort);
        window.location.href = url.toString();
    };
    
    // Add visual feedback for current sort
    const currentSort = new URLSearchParams(window.location.search).get('sort');
    if (currentSort) {
        const [column, direction] = currentSort.split('_');
        const headers = document.querySelectorAll('th button');
        headers.forEach(header => {
            const headerText = header.textContent.trim().toLowerCase();
            if (headerText === column || 
                (column === 'created' && headerText === 'created') ||
                (column === 'name' && headerText === 'user')) {
                header.classList.add('sort-active', `sort-${direction}`);
            }
        });
    }
    
    // Live search functionality
    const searchInput = document.getElementById('search');
    const roleSelect = document.getElementById('role');
    const sortSelect = document.getElementById('sort');
    
    // Auto-submit form when filters change
    if (roleSelect) {
        roleSelect.addEventListener('change', function() {
            this.closest('form').submit();
        });
    }
    
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            this.closest('form').submit();
        });
    }
    
    // Search with Enter key or auto-submit after typing stops
    let searchTimeout;
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (this.value.length >= 2 || this.value.length === 0) {
                    this.closest('form').submit();
                }
            }, 500); // Wait 500ms after user stops typing
        });
    }
    
    // Add hover effects to table rows
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        row.classList.add('table-hover-row');
    });
    
    // Reset password functionality
    window.resetPassword = function(userId) {
        document.getElementById('resetUserId').value = userId;
        document.getElementById('resetPasswordModal').classList.remove('hidden');
    };
    
    window.closeResetModal = function() {
        document.getElementById('resetPasswordModal').classList.add('hidden');
        document.getElementById('resetPasswordForm').reset();
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
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                password: password,
                password_confirmation: passwordConfirm
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('Password reset successfully!', 'success');
                closeResetModal();
            } else {
                showMessage(data.message || 'Error resetting password', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Error resetting password', 'error');
        });
    });
    
    // Delete user functionality
    window.deleteUser = function(userId) {
        if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
            fetch(`/admin/users/${userId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('User deleted successfully!', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showMessage(data.message || 'Error deleting user', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('Error deleting user', 'error');
            });
        }
    };
    
    function showMessage(message, type) {
        const alertClass = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
        document.getElementById('messageContainer').innerHTML = `
            <div class="${alertClass} px-4 py-3 rounded border shadow-lg">
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