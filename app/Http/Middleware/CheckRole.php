<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * CheckRole Middleware
 * 
 * Ensures users can only access routes appropriate for their role.
 * Prevents unauthorized access and maintains role separation.
 * 
 * @author DepEd LIS System
 * @version 1.0
 */
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['auth' => 'Please log in to access this page.']);
        }

        $user = Auth::user();
        $userRole = $user->role;
        
        // Log for debugging
        Log::info('CheckRole middleware triggered', [
            'user_id' => $user->id,
            'user_role' => $userRole,
            'required_roles' => $roles,
            'request_path' => $request->path(),
            'request_method' => $request->method()
        ]);

        // Check if user has any of the required roles
        if (in_array($userRole, $roles)) {
            Log::info('User has required role, allowing access', [
                'user_role' => $userRole,
                'required_roles' => $roles
            ]);
            return $next($request);
        }

        // Log the redirection
        Log::warning('User does not have required role, redirecting', [
            'user_role' => $userRole,
            'required_roles' => $roles
        ]);

        // Redirect based on user's actual role to prevent unauthorized access
        return $this->redirectToAppropriateArea($userRole, $request);
    }

    /**
     * Redirect user to their appropriate area based on role
     */
    private function redirectToAppropriateArea(string $userRole, Request $request): Response
    {
        $message = 'Access denied. You are being redirected to your designated area.';
        
        switch ($userRole) {
            case 'admin':
                return redirect('/admin/dashboard')->with('warning', $message);
            case 'adviser':
                return redirect('/dashboard')->with('warning', $message);
            case 'teacher':
                return redirect('/teacher-portal')->with('warning', $message);
            case 'student':
                return redirect('/portal/grades')->with('warning', $message);
            default:
                return redirect('/portal/login')->withErrors(['auth' => 'Invalid user role. Please contact administrator.']);
        }
    }
}