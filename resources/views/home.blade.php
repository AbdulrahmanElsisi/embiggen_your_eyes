@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
  <div class="text-center py-20">
    <h1 class="text-5xl font-extrabold mb-6">Embiggen Your Eyes</h1>
    <p class="text-lg text-gray-300 mb-8">
      Explore NASA’s massive images like never before. Zoom, label, and analyze celestial data.
    </p>
    <a href="{{ route('datasets') }}"
       class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg text-white font-semibold">
      Start Exploring
    </a>
  </div>
@endsection
