<?php

namespace App\ViewModels;

use Illuminate\Support\Carbon;
use Spatie\ViewModels\ViewModel;

/**
 * View Models are simple classes that take some data, and transform it into something usable for the view
 * Views ideally should not have complex logic inside them, that's why I decided to use View Models
 * note: I do not make use of any ViewModel's feature as of now but I will later.
 */
class MoviesViewModel extends ViewModel
{
    private $trendingMovies;
    private $genres;

    public function __construct(array $trendingMovies, array $genres)
    {
        $this->trendingMovies = $trendingMovies;
        $this->genres = $genres;
    }

    private function formatMovies($movies)
    {
        return collect($movies)->filter(function ($movie) {
            // Filter for only movies with rating greater than 5
            return (int) $movie['vote_average'] >= 5;
        })->map(function ($movie) {
            $genresFormatted = collect($movie['genre_ids'])
                ->map(function ($genre) {
                    return genres()[$genre] ?? null;
                })
                ->filter()
                ->implode(', ');

            // Overriding popularMovie with new modified values using merge() function
            return collect($movie)
                ->merge([
                    // TODO: Change original to low resolution in production
                    'backdrop_path' => 'https://image.tmdb.org/t/p/original/' . $movie['backdrop_path'],
                    'release_date' => Carbon::parse($movie['release_date'])->format('Y F'),
                    'vote_average' => round($movie['vote_average'], 1),
                    'genres' => $genresFormatted,
                ])
                ->only([
                    'title',
                    'original_title',
                    'vote_average',
                    'backdrop_path',
                    'release_date',
                    'genre_ids',
                    'overview',
                    'id',
                    'genres',
                    'media_type'
                ]);  // Return only items we want
        });
    }

    public function getTrendingMovies()
    {
        // collect() - Create a collection from the given value.
        return $this->formatMovies($this->trendingMovies);
    }
}
