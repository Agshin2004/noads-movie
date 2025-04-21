@extends('layout.layout')

@section('content')
    <div class="max-w-screen-lg mx-auto p-4 sm:p-8">
        {{-- Movie Header --}}
        <div class="flex flex-col sm:flex-row items-center space-y-6 sm:space-y-0 sm:space-x-8">
            <img src="{{ $movie['poster_path'] }}" alt="Movie Poster"
                class="w-full sm:w-48 sm:h-72 object-cover rounded-lg shadow-lg">
            <div>
                <h1 class="text-3xl sm:text-4xl font-bold mb-4">
                    {{ $movie['original_title'] }}
                    <sup class="text-xl font-bold text-yellow-400">{{ $movie['vote_average'] }}</sup>
                </h1>
                <div class="text-gray-400 text-lg sm:text-xl mb-4">
                    {{ $movie['release_date'] }} • {{ $movie['runtime'] }} min
                </div>
                <div class="flex flex-wrap space-x-4 mb-4">
                    @foreach ($movie['genres'] as $genre)
                        <span class="bg-orange-500 text-white px-4 py-1 rounded-full text-sm mb-2 sm:mb-0 m-2">
                            {{ $genre }}
                        </span>
                    @endforeach
                </div>
                <p class="text-gray-300 text-sm sm:text-base mb-4">{{ $movie['tagline'] }}</p>
                <button
                    class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded cursor-pointer"
                    data-micromodal-trigger="modal-1">
                    See Trailer
                </button>
            </div>
        </div>

        {{-- Movie Overview --}}
        <div class="mt-8">
            <h2 class="text-2xl sm:text-3xl font-semibold mb-4">Overview</h2>
            <p class="text-gray-300 text-sm sm:text-base">{{ $movie['overview'] }}</p>
        </div>

        {{-- Cast --}}
        <div class="mt-8">
            <h2 class="text-2xl sm:text-3xl font-semibold mb-4">Cast</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach ($movie['credits'] as $actor)
                    <div class="text-center">
                        <img src="https://image.tmdb.org/t/p/original/{{ $actor['profile_path'] }}" alt="Cast Member"
                            class="object-cover w-20 h-24 rounded-full mx-auto mb-2">
                        <p class="text-xl">
                            <a href="{{ route('person', $actor['id']) }}">{{ $actor['name'] }}</a>
                        </p>
                        <p class="text-gray-400">{{ $actor['character'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Trailer --}}
        <div class="micromodal" id="modal-1" aria-hidden="true">
            <div class="micromodal__overlay z-50" tabindex="-1" data-micromodal-close>
                <div class="micromodal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                    <div>
                        <div class="relative pb-56.25% z-100">
                            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{ $trailerKey }}"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PLAYER START --}}
        <div class="player-container">
            <h1
                class="mt-16 mb-8 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-1xl lg:text-4xl dark:text-white text-center">
                Watch
            </h1>
            <iframe src="https://vidsrc.cc/v3/embed/movie/{{ $movie['id'] }}?autoPlay=false?"
                class="player-iframe" allowfullscreen></iframe>
        </div>
        {{-- PLAYER END --}}

        {{-- Images --}}
        <h1
            class="mt-16 mb-8 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-1xl lg:text-4xl dark:text-white text-center">
            Images
        </h1>
        <div class="images-wrapper">
            <div class="splide" id="image-slider">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($movie['images'] as $image)
                            <li class="splide__slide">
                                <img src="https://image.tmdb.org/t/p/original/{{ $image['file_path'] }}">
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- TODO: ADD CRITIC REVIEWS; Critic Reviews --}}
@endsection