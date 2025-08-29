@extends('layouts.student')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 px-4 py-3 gap-3">
        <div class="flex items-center justify-between max-w-7xl mx-auto">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-blue-600 rounded flex items-center justify-center">
                    <span class="text-white font-bold text-sm">DepEd</span>
                </div>
                <span class="text-gray-700 font-medium">Single Sign On</span>
            </div>
            <div class="text-right">
                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">Help</a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex justify-center items-center" style="min-height: calc(100vh - 50px);">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                <h1 class="text-2xl font-normal text-gray-800 mb-8 text-center">Please sign in</h1>
                
                <form action="{{ url('/login') }}" method="POST">
                    @csrf
                    
                    @if($errors->has('login'))
                        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded text-red-700 text-sm">
                            {{ $errors->first('login') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <input type="text" 
                               name="username"
                               class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="Username"
                               value="{{ old('username', 'adviser1') }}"
                               required>
                    </div>

                    <div class="mb-6">
                        <input type="password" 
                               name="password"
                               class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="Password"
                               value="password"
                               required>
                    </div>

                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-sm font-medium transition duration-200">
                        Sign in
                    </button>
                </form>

                <!-- Demo Credentials -->
                <div class="mt-6 p-4 bg-blue-50 rounded border border-blue-200">
                    <h4 class="text-sm font-medium text-blue-900 mb-2">Demo Credentials</h4>
                    <div class="text-sm text-blue-700 space-y-1">
                        <div><strong>Adviser:</strong> adviser1 / password</div>
                        <div><strong>Student:</strong> student1 / password</div>
                    </div>
                </div>

                <div class="mt-8 p-4 bg-gray-50 rounded border">
                    <h3 class="font-medium text-gray-800 mb-2">Forgot password?</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        For class advisers, request School Head or designated school system administrator to reset password. 
                        For school heads, request Division Planning Officer to reset password.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center py-4 text-gray-500 text-sm">
        Department of Education
    </div>
</div>
@endsection
