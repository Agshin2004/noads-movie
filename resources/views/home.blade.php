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
                @foreach ($moviesAndShows as $movieShow)
                            <li class="splide__slide px-2">
                                @include('partials.card', [
                                    'id' => $movieShow['id'],
                                    'title' => $movieShow['original_title'],
                                    'rating' => $movieShow['vote_average'],
                                    'poster' => $movieShow['backdrop_path'],
                                    'releaseDate' => $movieShow['release_date'],
                                    'genreIds' => $movieShow['genre_ids'],
                                    'movieId' => $movieShow['id'],
                                    'genres' => $movieShow['genres'],
                                    'mediaType' => $movieShow['media_type']
                                ])
                            </li>
                @endforeach
                </ul>
            </div>
        </div>
@endsection