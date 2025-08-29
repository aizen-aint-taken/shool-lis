@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Class</h1>

<form class="bg-white p-6 rounded shadow w-full max-w-lg">
    <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Class Name</label>
        <input type="text" class="w-full border rounded px-3 py-2" value="Grade 7 - A">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Adviser</label>
        <input type="text" class="w-full border rounded px-3 py-2" value="Mr. Cruz">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium mb-1">School Year</label>
        <input type="text" class="w-full border rounded px-3 py-2" value="2025-2026">
    </div>

    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Update Class</button>
</form>
@endsection
