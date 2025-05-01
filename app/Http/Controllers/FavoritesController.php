<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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

        $movieShows = collect($this->getMovies($favorites))->map(function ($movie) {
            $genres = collect($movie['genres'])->map(function($genre) {
                return $genre['name'];
            })->toarray();

            return collect($movie)->merge([
                'poster_path' => $movie['poster_path'] ? 'https://image.tmdb.org/t/p/w300/' . $movie['poster_path'] : asset('images/notfound.jpg'),
                'release_date' => Carbon::parse($movie['release_date'] ?? $movie['first_air_date'])->format('Y F'),
                'vote_average' => round($movie['vote_average'], 1),
                'genres' => implode(', ', $genres)
            ]);
        })->reverse(); // Reverse items order so newly added movie/shows will come first
        // dump($movieShows);



        // Pagination
        $perPage = 5; // number of items to show per page

        // Get current page from query string if not present default to 1
        $currentPage = request()->input('page', 1);

        $currentPageItems = $movieShows->slice(($currentPage - 1) * $perPage, $perPage);

        $paginatedItems = new LengthAwarePaginator(
            $currentPageItems,
            $movieShows->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(), // Keep the current url (no query string), default it would add page query to / and it can mes up
                'query' => request()->query() // keep the query params if filters added
            ],
        );

        return view('favorites', [
            'movies' => $paginatedItems->items(),
            'links' => $paginatedItems->links('vendor.pagination.custom-pagination'),
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
