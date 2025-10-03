@extends('layouts.app')

@section('title', 'Planets & Space Bodies')

@section('content')
  <h1 class="text-3xl font-bold mb-6">Explore Planets & Space Bodies</h1>
  <p class="mb-8 text-gray-300">Choose a celestial body to start zooming into real NASA datasets.</p>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Earth -->
    <div class="bg-gray-800 rounded-lg p-6 shadow hover:shadow-lg transition">
      <h2 class="text-xl font-bold mb-2">🌍 Earth</h2>
      <p class="text-gray-400 mb-4">High-resolution Earth observation images from satellites.</p>
      <a href="{{ route('explore.show', ['planet' => 'earth']) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Explore</a>

    </div>

    <!-- Mars -->
    <div class="bg-gray-800 rounded-lg p-6 shadow hover:shadow-lg transition">
      <h2 class="text-xl font-bold mb-2">🔴 Mars</h2>
      <p class="text-gray-400 mb-4">Gigapixel images from the Mars Reconnaissance Orbiter.</p>
      <a href="{{ route('explore.show', ['planet' => 'mars']) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Explore</a>
    </div>

    <!-- Moon -->
    <div class="bg-gray-800 rounded-lg p-6 shadow hover:shadow-lg transition">
      <h2 class="text-xl font-bold mb-2">🌙 Moon</h2>
      <p class="text-gray-400 mb-4">Lunar surface maps from the Lunar Reconnaissance Orbiter.</p>
      <a href="{{ route('explore.show', ['planet' => 'moon']) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Explore</a>
    </div>

    <!-- Jupiter -->
    <div class="bg-gray-800 rounded-lg p-6 shadow hover:shadow-lg transition">
      <h2 class="text-xl font-bold mb-2">🟠 Jupiter</h2>
      <p class="text-gray-400 mb-4">Explore stormy atmospheres and Great Red Spot imagery.</p>
      <a href="{{ route('explore.show', ['planet' => 'jupiter']) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Explore</a>
    </div>

    <!-- Saturn -->
    <div class="bg-gray-800 rounded-lg p-6 shadow hover:shadow-lg transition">
      <h2 class="text-xl font-bold mb-2">🪐 Saturn</h2>
      <p class="text-gray-400 mb-4">Ring structures and planetary data from NASA missions.</p>
      <a href="{{ route('explore.show', ['planet' => 'saturn']) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Explore</a>
    </div>

    <!-- Exoplanets -->
    <div class="bg-gray-800 rounded-lg p-6 shadow hover:shadow-lg transition">
      <h2 class="text-xl font-bold mb-2">✨ Exoplanets</h2>
      <p class="text-gray-400 mb-4">Discover worlds beyond our Solar System with TESS data.</p>
      <a href="{{ route('explore.show', ['planet' => 'exoplanets']) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Explore</a>
    </div>
  </div>
@endsection
