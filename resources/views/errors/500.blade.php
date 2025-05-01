@extends('layout.layout')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center bg-black text-white text-center px-4">
        <h1 class="text-5xl font-extrabold tracking-widest text-red-600">404</h1>
        <p class="text-2xl md:text-4xl font-bold mt-4">Page Not Found</p>
        <p class="mt-4 mb-8 text-sm md:text-base text-gray-400">Server error. Contact Admins.</p>
        <a href="{{ url('/') }}"
           class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-lg transition">
            Back to Home
        </a>
    </div>
@endsection
