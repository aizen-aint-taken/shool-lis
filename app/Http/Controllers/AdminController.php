<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        // Only administrators can access
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Only administrators can access this page.');
        }

        $totalUsers = User::count();
        $totalAdvisers = User::where('role', 'adviser')->count();
        $totalTeachers = User::where('role', 'teacher')->count();
        $totalStudents = User::where('role', 'student')->count();
        $totalClasses = SchoolClass::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAdvisers',
            'totalTeachers',
            'totalStudents',
            'totalClasses'
        ));
    }

    /**
     * Show user management interface
     */
    public function users(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Only administrators can manage users.');
        }

        $query = User::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('username', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Role filtering
        if ($request->filled('role')) {
            $query->where('role', $request->get('role'));
        }

        // Sorting functionality
        $sort = $request->get('sort', 'created_desc');
        switch ($sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'role_asc':
                $query->orderBy('role', 'asc');
                break;
            case 'role_desc':
                $query->orderBy('role', 'desc');
                break;
            case 'email_asc':
                $query->orderBy('email', 'asc');
                break;
            case 'email_desc':
                $query->orderBy('email', 'desc');
                break;
            case 'created_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'created_desc':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $users = $query->paginate(20)->appends($request->query());

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show create adviser form
     */
    public function createAdviser()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Only administrators can create adviser accounts.');
        }

        return view('admin.users.create-adviser');
    }

    /**
     * Store new adviser
     */
    public function storeAdviser(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Only administrators can create adviser accounts.'
            ], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'employee_id' => 'nullable|string|max:50',
            'position' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
        ]);

        try {
            $adviser = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'adviser',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Adviser account created successfully!',
                'adviser' => $adviser,
                'credentials' => [
                    'username' => $request->username,
                    'password' => $request->password
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating adviser account: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show user details
     */
    public function showUser($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Only administrators can view user details.');
        }

        $user = User::with('advisedClasses')->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Edit user
     */
    public function editUser($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Only administrators can edit users.');
        }

        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, $id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Only administrators can update users.'
            ], 403);
        }

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|string|in:admin,adviser,teacher,student',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        try {
            $userData = [
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'role' => $request->role,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully!',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating user: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete user
     */
    public function deleteUser($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Only administrators can delete users.'
            ], 403);
        }

        try {
            $user = User::findOrFail($id);

            // Prevent deleting the current admin
            if ($user->id === Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot delete your own account.'
                ], 400);
            }

            // Check if user is an adviser with assigned classes
            if ($user->role === 'adviser' && $user->advisedClasses()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete adviser with assigned classes. Please reassign classes first.'
                ], 400);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting user: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reset user password
     */
    public function resetPassword(Request $request, $id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Only administrators can reset passwords.'
            ], 403);
        }

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $user = User::findOrFail($id);

            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password reset successfully!',
                'new_password' => $request->password
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error resetting password: ' . $e->getMessage()
            ], 500);
        }
    }
}
