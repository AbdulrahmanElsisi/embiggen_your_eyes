@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-10 text-center text-white">
    <h1 class="text-4xl font-bold mb-6">🔍 Search in Image</h1>

    @if(session('error'))
        <div class="bg-red-500 p-2 rounded mb-4">{{ session('error') }}</div>
    @endif

    <form action="{{ route('image.search') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" class="mb-2 p-2 rounded text-black" required>
        <input type="text" name="object" placeholder="Enter object name (e.g., person)" class="mb-2 p-2 rounded text-black" required>
        <button type="submit" class="bg-blue-500 px-4 py-2 rounded">Search & Highlight</button>
    </form>

    @if(isset($outputPath))
        <h2 class="text-lg mt-4 mb-2">Result:</h2>
        <img src="{{ $outputPath }}" class="w-full h-80 border rounded mx-auto" />
    @endif
</div>
@endsection
