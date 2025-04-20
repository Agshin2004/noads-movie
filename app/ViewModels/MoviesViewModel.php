<?php

namespace App\ViewModels;

use Illuminate\Support\Carbon;
use Spatie\ViewModels\ViewModel;

class MoviesViewModel extends ViewModel
{
    public $popularMovies;
    public $genres;

    public function __construct(array $popularMovies, array $genres)
    {
        $this->popularMovies = $popularMovies;
        $this->genres = $genres;
    }

    private function formatMovies($movies)
    {
        // @foreach ($genreIds as $genreId)
        //     {{ $genresName[$genreId] }}@if (!$loop->last),@endif
        // @endforeach

        return collect($movies)->map(function ($movie) {
            $genresFormatted = collect($movie['genre_ids'])->mapWithKeys(function ($genreKey) {
                return [$genreKey => $this->getGenres()->get($genreKey)]; 
            })->implode(', ');
            // Overriding popularMovie with new modified values using merge() function
            return collect($movie)->merge([
                // TODO: Change original to low resolution in production
                'backdrop_path' => "https://image.tmdb.org/t/p/original/" . $movie['backdrop_path'],
                'release_date' => Carbon::parse($movie['release_date'])->format('Y F'),
                'vote_average' => round($movie['vote_average'], 1),
                'genres' => $genresFormatted
            ])->only(['original_title', 'vote_average', 'backdrop_path', 'release_date', 'genre_ids', 'id', 'genres']); // Return only items we want
        });
    }

    public function getPopularMovies()
    {
        // collect() - Create a collection from the given value.
        return $this->formatMovies($this->popularMovies);
    }

    private function getGenres()
    {
        // convert genres to [1 => 'Action] format 
        $genresName = [];
        foreach ($this->genres as $genre) {
            $genresName[$genre['id']] = $genre['name'];
        }

        return collect($genresName);
    }
}
