@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Students</h1>

<div class="mb-4">
    <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">+ Add Student</a>
</div>

<table class="w-full bg-white border rounded shadow">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3 border">#</th>
            <th class="p-3 border">Student Name</th>
            <th class="p-3 border">Class</th>
            <th class="p-3 border">Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="p-3 border">1</td>
            <td class="p-3 border">Juan Dela Cruz</td>
            <td class="p-3 border">Grade 7 - A</td>
          
        </tr>
    </tbody>
</table>
@endsection
