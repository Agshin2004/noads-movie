@extends('layout.layout')

@section('content')
    <h1
        class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-1xl lg:text-2xl dark:text-white text-center mt-5">
        20 TRENDING MOVIES!
    </h1>
    {{-- Movie cards wrapper --}}
    <div class="flex flex-wrap gap-5 m-6 justify-center">
        <div class="flex flex-direction flex-wrap gap-5 m-6">
            @foreach ($movies as $movie)
                    @include('partials.card', [
                        'title' => $movie['original_title'],
                        'rating' => $movie['vote_average'],
                        'poster' => $movie['backdrop_path'],
                        'releaseDate' => $movie['release_date'],
                        'genreIds' => $movie['genre_ids'],
                        'movieId' => $movie['id'],
                        'genres' => $movie['genres_ids'],
                    ])
            @endforeach
            </div>
    </div>
@endsection