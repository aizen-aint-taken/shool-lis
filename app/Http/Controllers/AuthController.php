<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // Simple demo temporary
        if ($username === 'adviser1' && $password === 'password') {

            session(['user_type' => 'adviser', 'username' => $username]);
            return redirect('/dashboard');
        } elseif ($username === 'student1' && $password === 'password') {

            session(['user_type' => 'student', 'username' => $username]);
            return redirect('/portal/grades');
        } else {
            return back()->withErrors(['login' => 'Invalid username or password']);
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect('/portal/login');
    }
}
