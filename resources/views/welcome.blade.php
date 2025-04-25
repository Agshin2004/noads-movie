@extends('layout.layout')

@section('content')
    <section class="bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center px-4">
        <div
            class="w-full max-w-lg bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 sm:p-8 space-y-6 m-5                                                                                                                                                                                                                                                                                                                                                                                               ">
            <div class="text-center">
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">Welcome to ZMA Movies 🎬</h1>
                <p class="mt-2 text-base text-gray-600 dark:text-gray-400">
                    Your account is ready.
                </p>
            </div>

            <div class="bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                    Your auto-generated password:
                    <span class="password text-xl text-green-500">{{ $password }}</span>
                </p>
                <div class="mt-3 text-center">
                    <button
                        class="copy-password px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition cursor-pointer">
                        Copy Password
                    </button>
                    <p class="text-xs text-gray-400 mt-2">Copy this somewhere safe - YOU WON'T SEE IT AGAIN.</p>
                </div>
            </div>

            <div class="text-center">
                <p class="text-red-600 text-sm sm:text-base">
                    MAKE SURE YOU COPIED AND SAVED PASSWORD BEFORE GOING TO HOME PAGE
                </p>
            </div>

            <div class="text-center">
                <a href="{{ route('index') }}"
                    class="inline-block w-full px-5 py-3 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition-all duration-200 text-center text-sm sm:text-base">
                    Enter ZMA Movies
                </a>
            </div>
        </div>
    </section>
@endsection