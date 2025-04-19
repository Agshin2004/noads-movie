@extends('layout.layout')

@section('content')


    <div class="max-w-screen-lg mx-auto p-4 sm:p-8">
        <!-- Movie Header -->
        <div class="flex flex-col sm:flex-row items-center space-y-6 sm:space-y-0 sm:space-x-8">
            <img src="https://image.tmdb.org/t/p/original/{{ $movie['poster_path'] }}" alt="Movie Poster"
                class="w-full sm:w-48 sm:h-72 object-cover rounded-lg shadow-lg">
            <div>
                <h1 class="text-3xl sm:text-4xl font-bold mb-4">{{ $movie['original_title'] }}</h1>
                <div class="text-gray-400 text-lg sm:text-xl mb-4">
                    {{ \Carbon\Carbon::parse($movie['release_date'])->format('Y, F') }} • {{ $movie['runtime'] }} min
                </div>
                <div class="flex flex-wrap space-x-4 mb-4">
                    @foreach ($movie['genres'] as $genre)
                        <span
                            class="bg-{{ array_rand(['green' => 3, 'blue' => 2, 'red' => 1, 'cyan' => 0], 1) }}-500 text-white px-4 py-1 rounded-full text-sm mb-2 sm:mb-0">
                            {{ $genresName[$genre['id']] }}
                        </span>
                    @endforeach
                </div>
                <p class="text-gray-300 text-sm sm:text-base mb-4">{{ $movie['tagline'] }}</p>
            </div>
        </div>

        <!-- Movie Overview -->
        <div class="mt-8">
            <h2 class="text-2xl sm:text-3xl font-semibold mb-4">Overview</h2>
            <p class="text-gray-300 text-sm sm:text-base">{{ $movie['overview'] }}</p>
        </div>

        <!-- Cast -->
        <div class="mt-8">
            <h2 class="text-2xl sm:text-3xl font-semibold mb-4">Cast</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach ($movie['credits']['cast'] as $actor)
                    <div class="text-center">
                        @if ($loop->iteration > 5)
                            @break
                        @endif
                        <img src="https://image.tmdb.org/t/p/original/{{ $actor['profile_path'] }}" alt="Cast Member"
                            class="object-cover w-20 h-24 rounded-full mx-auto mb-2">
                        <p class="text-xl">{{ $actor['name'] }}</p>
                        <p class="text-gray-400">{{ $actor['character'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Trailer -->
        <div class="mt-8">
            <h2 class="text-2xl sm:text-3xl font-semibold mb-4">Trailer</h2>
            <div class="relative pb-56.25% mb-4">
                <iframe width="100%" height="315" src="https://www.youtube.com/embed/{{ $trailerKey }}"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
        <!-- PLAYER START -->
        <div class="player-container">
            <iframe src="https://vidlink.pro/movie/{{ $movie['id'] }}?autoplay=false&primaryColor=001e3a" class="player-iframe" allowfullscreen></iframe>
        </div>
        <!-- PLAYER END -->

        <!-- Images -->
        <h1
            class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-1xl lg:text-2xl dark:text-white text-center">
            Images
        </h1>
        <div class="images-wrapper">
            <div class="splide" id="image-slider">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($movie['images']['backdrops'] as $image)
                            <li class="splide__slide">
                                <img src="https://image.tmdb.org/t/p/original/{{ $image['file_path'] }}">
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!-- Ratings -->
        <div class="mt-8">
            <h2 class="text-2xl sm:text-3xl font-semibold mb-4">Ratings</h2>
            <div class="flex items-center">
                <span class="text-5xl font-bold text-yellow-400">{{ round($movie['vote_average'], 1) }}</span>
                <span class="text-gray-400 ml-4">/10</span>
            </div>
            <div class="mt-2 text-gray-400">IMDb Rating</div>
        </div>
    </div>
@endsection