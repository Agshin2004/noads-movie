<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class FavoritesController extends Controller
{
    private string $apiKey;
    private string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('moviedb.api_key');
        $this->baseUrl = config('moviedb.base_url');
    }

    public function myFavorites()
    {
        // Get all movies/show ids from favorites
        $favoriteIds = auth()->user()->favorites->pluck('movieOrShowId')->toArray();

        // Filter out failed responses (since show ids are mixed up when show id is requested request will fail)
        $movies = array_filter($this->getMovies($favoriteIds), function ($movie) {
            return !isset($movie['success']);
        });

        $movies = collect($movies)->map(function ($movie) {
            return collect($movie)->merge([
                'poster_path' => 'https://image.tmdb.org/t/p/original/' . $movie['poster_path'],
                'release_date' => Carbon::parse($movie['release_date'])->format('Y F'),
                'vote_average' => round($movie['vote_average'], 1),
                'genres' => 'genresFormatted'
            ]);
        });
        dump($movies);

        return view('favorites', [
            'movies' => $movies
        ]);
    }

    private function getMovies(array $ids)
    {
        $movies = [];
        foreach ($ids as $id) {
            $movies[] = Http::withToken($this->apiKey)
                ->get("$this->baseUrl/movie/$id")
                ->json();
        }

        return $movies;
    }
}
