@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center h-[70vh]">
    <div class="w-full max-w-sm bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-4 text-center">Admin / Teacher Login</h2>

        <form>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" class="w-full border rounded px-3 py-2" placeholder="Enter your email">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" class="w-full border rounded px-3 py-2" placeholder="Enter password">
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Login
            </button>
        </form>
    </div>
</div>
@endsection
