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
                                {{-- Background image with gradient overlay --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-black/30 z-10"></div>
                                <img src="{{ $movieShow['backdrop_path'] }}"
                                    alt="{{ $movieShow['title'] ?? $movieShow['name'] }}"
                                    class="absolute inset-0 w-full h-full object-cover" loading="lazy">

                                {{-- Slide content --}}
                                <div class="relative z-20 h-full flex items-end pb-16 sm:items-center sm:pb-0">
                                    <div class="container mx-auto px-6 text-white">
                                        @if (
                                            (isset($movieShow['original_title'], $movieShow['title']) && $movieShow['original_title'] !== $movieShow['title']) 
                                            ||
                                            (isset($movieShow['original_name'], $movieShow['name']) && $movieShow['original_name'] !== $movieShow['name'])
                                        )
                                            <span class="text-lg sm:text-xl md:text-2xl text-gray-200 italic mb-2 block">
                                                {{ $movieShow['original_title'] ?? $movieShow['original_name'] }}
                                            </span>                                
                                        @endif
                                        <h2 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold mb-4 leading-tight">
                                            {{ $movieShow['title'] ?? $movieShow['name'] }}
                                        </h2>
                                        
                                        {{-- vote, year, type --}}
                                        <div class="flex items-center mb-4 flex-wrap gap-3">
                                            <span class="bg-amber-400 text-gray-900 px-3 py-1 rounded-full text-sm font-bold flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                {{ round($movieShow['vote_average'], 1) }}
                                            </span>
                                            <span class="text-lg sm:text-xl">{{ date('Y', strtotime($movieShow['release_date'])) }}</span>
                                            @if(isset($movieShow['media_type']))
                                                <span class="bg-blue-500/90 text-white px-3 py-1 rounded-full text-sm font-semibold uppercase">
                                                    {{ $movieShow['media_type'] }}
                                                </span>
                                            @endif
                                        </div>
                                        
                                        {{-- Genres --}}
                                        <div class="flex flex-wrap gap-2 mb-6">
                                            <span class="bg-purple-600/90 text-white px-4 py-1.5 rounded-full text-sm font-semibold">
                                                {{ $movieShow['genres'] }}
                                            </span>
                                        </div>
                                        
                                        {{-- Description --}}
                                        <p class="max-w-2xl text-base sm:text-lg md:text-xl mb-8 line-clamp-3 sm:line-clamp-4 text-gray-100">
                                            {{ $movieShow['overview'] ?? 'No description available' }}
                                        </p>
                                        
                                        <a href="{{ movieOrShowLink($movieShow['media_type'], $movieShow['id']) }}"
                                            class="text-sm sm:text-base bg-red-600 hover:bg-red-700 text-white px-6 sm:px-8 py-3 sm:py-3.5 rounded-lg font-bold inline-flex items-center transition transform hover:scale-105">
                                            View Details
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
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
            <button class="splide__arrow splide__arrow--prev bg-black/70 hover:bg-black p-3 sm:p-4 rounded-full transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-6 h-6 sm:w-8 sm:h-8 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button class="splide__arrow splide__arrow--next bg-black/70 hover:bg-black p-3 sm:p-4 rounded-full transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-6 h-6 sm:w-8 sm:h-8 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        {{-- Custom pagination --}}
        <div class="splide__pagination splide__pagination--ltr">
            @foreach ($moviesAndShows as $index => $movieShow)
                <button class="splide__pagination__page bg-white/30 hover:bg-white/50 mx-1.5 w-3 h-3 sm:w-4 sm:h-4 transition" 
                        aria-label="Go to slide {{ $index + 1 }}"></button>
            @endforeach
        </div>

        {{-- Progress bar --}}
        <div class="splide__progress">
            <div class="splide__progress__bar bg-gradient-to-r from-red-500 to-amber-400 h-1.5"></div>
        </div>
    </div>
@endsection