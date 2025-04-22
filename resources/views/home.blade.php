@extends('layout.layout')

@section('content')
    <h1
        class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-1xl lg:text-2xl dark:text-white text-center mt-5">
        Latest TRENDING
    </h1>
    {{-- Splide Slider Container --}}
    <div id="movies-slider" class="splide mx-auto max-w-7xl px-4 py-8" aria-label="Trending Movies Slider">
        <div class="splide__track">
            <ul class="splide__list">
                @foreach ($movies as $movie)
                            <li class="splide__slide px-2">
                                @include('partials.card', [
                                    'title' => $movie['original_title'],
                                    'rating' => $movie['vote_average'],
                                    'poster' => $movie['backdrop_path'],
                                    'releaseDate' => $movie['release_date'],
                                    'genreIds' => $movie['genre_ids'],
                                    'movieId' => $movie['id'],
                                    'genres' => $movie['genres'],
                                ])
                                    </li>
                @endforeach
                </ul>
            </div>
        </div>
@endsection