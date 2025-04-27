@extends('layout.layout')

@section('content')
<div class="w-1/2 bg-gradient-to-r from-pink-500 via-yellow-400 to-purple-600 text-white text-center py-8 mt-5 mb-6 rounded-lg shadow-md  mx-auto">
    <h1 class="text-4xl font-extrabold">Favorites</h1>
</div>
    <div class="flex flex-wrap">
        @foreach($movies as $movie)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 m-5">
                @include('partials.card', [
                    'id' => $movie['id'],
                    'title' => isset($movie['name']) ? $movie['name'] : $movie['title'],
                    'rating' => $movie['vote_average'],
                    'poster' => $movie['poster_path'],
                    'releaseDate' => isset($movie['first_air_date']) ? $movie['first_air_date'] : $movie['release_date'],
                    'movieId' => $movie['id'],
                    'genres' => "",
                    'mediaType' => isset($movie['name']) ? 'tv' : 'movie'
                ])
                        </div>
        @endforeach
        </div>
@endsection
