<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');


        $user = User::where('username', $username)->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user);

            // Redirect based on role
            switch ($user->role) {
                case 'admin':
                    return redirect('/admin/dashboard');
                case 'adviser':
                    return redirect('/dashboard');
                case 'teacher':
                    return redirect('/teacher-portal');
                case 'student':
                    return redirect('/portal/grades');
                default:
                    return redirect('/dashboard');
            }
        }

        return back()->withErrors(['login' => 'Invalid username or password']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/portal/login');
    }
}
