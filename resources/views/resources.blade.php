@extends('layouts.app')

@section('title', 'Resources')

@section('content')
  <h1 class="text-3xl font-bold mb-6">NASA & Partner Resources</h1>
  <ul class="list-disc pl-6 space-y-2">
    <li><a href="https://worldview.earthdata.nasa.gov/" target="_blank" class="text-blue-600">NASA Worldview</a></li>
    <li><a href="https://pds-imaging.jpl.nasa.gov/volumes/mro.html" target="_blank" class="text-blue-600">Mars Reconnaissance Orbiter</a></li>
    <li><a href="https://trek.nasa.gov/" target="_blank" class="text-blue-600">Solar System Treks</a></li>
    <li><a href="https://search.earthdata.nasa.gov/" target="_blank" class="text-blue-600">EarthData</a></li>
    <!-- تزود باقي المصادر اللي عندك -->
  </ul>
@endsection
