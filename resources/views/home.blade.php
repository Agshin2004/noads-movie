@extends('layout.layout')

@section('content')
    <div id="fullpage-slider" class="splide" aria-label="Full Page Slider">
        <div class="splide__track">
            <ul class="splide__list">
                @foreach ($moviesAndShows as $movieShow)
                    <a href="{{ movieOrShowLink($movieShow['media_type'], $movieShow['id']) }}">
                        <li class="splide__slide">
                            {{-- Full page slide content --}}
                            <div class="relative h-screen w-full">
                                {{-- Background i mage --}}
                                <div class="absolute inset-0 bg-black/50 z-10"></div>
                                <img src="https://image.tmdb.org/t/p/original{{ $movieShow['backdrop_path'] }}"
                                    alt="{{ $movieShow['title'] ?? $movieShow['name'] }}"
                                    class="absolute inset-0 w-full h-full object-cover" loading="lazy">

                                {{-- Slide content --}}
                                <div class="relative z-20 h-full flex items-center">
                                    <div class="container mx-auto px-4 text-white">
                                        @if (
                                            (isset($movieShow['original_title'], $movieShow['title']) && $movieShow['original_title'] !== $movieShow['title']) 
                                            ||
                                            (isset($movieShow['original_name'], $movieShow['name']) && $movieShow['original_name'] !== $movieShow['name'])
                                        )
                                            <span
                                                class="text-2xl md:text-xl sm:text-sm"
                                                >
                                                {{ $movieShow['original_title'] ?? $movieShow['original_name'] }}
                                            </span>                                
                                        @endif
                                        <h2 class="text-2xl sm:text-4xl md:text-6xl font-bold mb-4">
                                            {{ $movieShow['title'] ?? $movieShow['name'] }}</h2>
                                        {{-- vote, year, type --}}
                                        <div class="flex items-center mb-4">
                                            <span class="bg-yellow-500 text-black px-2 py-1 rounded mr-4">
                                                {{ round($movieShow['vote_average'], 1) }}/10
                                            </span>
                                            <span class="mr-4">{{ date('Y', strtotime($movieShow['release_date'])) }}</span>
                                            @if(isset($movieShow['media_type']))
                                                <span class="uppercase">{{ $movieShow['media_type'] }}</span>
                                            @endif
                                        </div>
                                        {{-- Genres --}}
                                        <div class="flex flex-wrap gap-2 mb-6">
                                                <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                                    {{ $movieShow['genres'] }}
                                                </span>
                                        </div>
                                        {{-- Description --}}
                                        <p class="max-w-2xl text-xs sm:text-sm md:text-lg mb-8 line-clamp-3">
                                            {{ $movieShow['overview'] ?? 'No description available' }}
                                        </p>
                                        <a href="{{ movieOrShowLink($movieShow['media_type'], $movieShow['id']) }}"
                                        class="text-xs sm:text-sm md:text-base bg-red-600 hover:bg-red-700 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-semibold inline-block transition">
                                        View Details
                                    </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </a>
                @endforeach
            </ul>
        </div>

        {{-- Custom arrows --}}
        <div class="splide__arrows">
            <button class="splide__arrow splide__arrow--prev bg-black/50 p-4 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button class="splide__arrow splide__arrow--next bg-black/50 p-4 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        {{-- Progress bar --}}
        <div class="splide__progress">
            <div class="splide__progress__bar bg-red-600"></div>
        </div>
    </div>


    @push('scripts')
        @if (session('fail'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    alertify.error('{{ session('fail') }}');
                });
            </script>
        @endif
    @endpush
@endsection