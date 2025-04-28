@extends('layout.layout')

@section('content')
    <div
        class="w-1/2 bg-gradient-to-r from-pink-500 via-yellow-400 to-purple-600 text-white text-center py-8 mt-5 mb-6 rounded-lg shadow-md  mx-auto">
        <h1 class="text-4xl font-extrabold">Favorites</h1>
    </div>
    <div class="flex flex-wrap justify-center">

        @forelse($movies as $movie)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 m-5">
                @include('partials.card', [
                    'id' => $movie['id'],
                    'title' => isset($movie['name']) ? $movie['name'] : $movie['title'],
                    'rating' => $movie['vote_average'],
                    'poster' => $movie['poster_path'],
                    'releaseDate' => $movie['release_date'],
                    'movieId' => $movie['id'],
                    'genres' => $movie['genres'],
                    'mediaType' => isset($movie['name']) ? 'tv' : 'movie',
                ])
            </div>
        @empty
            <h2
                class="mt-10 mb-10 text-4xl sm:text-5xl text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-red-500 to-yellow-500 animate-bounce">
                No Movies here...
            </h2>
        @endforelse
    </div>
@endsection
