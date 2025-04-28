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
        $favorites = auth()->user()->favorites->toArray();
        dump($this->getMovies($favorites));
        $movieShows = collect($this->getMovies($favorites))->map(function ($movie) {
            $genres = collect($movie['genres'])->map(function($genre) {
                return $genre['name'];
            })->toarray();

            return collect($movie)->merge([
                'poster_path' => 'https://image.tmdb.org/t/p/original/' . $movie['poster_path'],
                'release_date' => Carbon::parse($movie['release_date'] ?? $movie['first_air_date'])->format('Y F'),
                'vote_average' => round($movie['vote_average'], 1),
                'genres' => implode(', ', $genres)
            ]);
        })->reverse(); // Reverse items order so newly added movie/shows will come first
        // dump($movieShows);

        return view('favorites', [
            'movies' => $movieShows
        ]);
    }

    private function getMovies(array $favorites)
    {
        $movieShows = [];
        foreach ($favorites as $favorite) {
            $type = $favorite['type'];
            $id = $favorite['movieOrShowId'];
            $movieShows[] = Http::withToken($this->apiKey)
                ->get("$this->baseUrl/$type/$id")
                ->json();
        }


        return $movieShows;
    }
}
