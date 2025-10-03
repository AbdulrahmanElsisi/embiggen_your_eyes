<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Explorer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">

    <!-- Navbar -->
    <nav class="bg-gray-800 p-4 flex justify-between">
        <a href="{{ route('landing') }}" class="font-bold text-lg">🌌 Space Explorer</a>
        <div class="space-x-6">
            <a href="{{ route('datasets.index') }}">Datasets</a>
            {{-- <a href="{{ route('about') }}">About</a>
            <a href="{{ route('contact') }}">Contact</a> --}}
        </div>
    </nav>

    <!-- Main Content -->
    <div class="p-8">
        @yield('content')
    </div>

</body>
</html>
