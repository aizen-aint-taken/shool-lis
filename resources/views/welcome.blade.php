<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel + Tailwind v4</title>

    {{-- Load Tailwind & JS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-green-500 text-white flex items-center justify-center min-h-screen">
    <h1 class="text-5xl font-bold">
        Tailwind v4 Works 🎉
    </h1>
</body>
</html>
