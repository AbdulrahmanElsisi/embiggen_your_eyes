@extends('layouts.app')

@section('title', 'Contact')

@section('content')
  <div class="max-w-lg mx-auto py-12">
    <h1 class="text-3xl font-bold mb-6">Get in Touch ✉️</h1>

    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
      @csrf
      <input type="text" name="name" placeholder="Your Name" class="w-full p-3 border rounded" required>
      <input type="email" name="email" placeholder="Your Email" class="w-full p-3 border rounded" required>
      <textarea name="message" rows="5" placeholder="Your Message" class="w-full p-3 border rounded" required></textarea>
      <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white px-6 py-3 rounded-lg">Send</button>
    </form>
  </div>
@endsection
