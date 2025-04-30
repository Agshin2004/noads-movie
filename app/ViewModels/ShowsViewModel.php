<?php

namespace App\ViewModels;

use Illuminate\Support\Carbon;
use Spatie\ViewModels\ViewModel;

class ShowsViewModel extends ViewModel
{
    private $trendingShows;
    private $genres;

    public function __construct(array $trendingShows, array $genres)
    {
        $this->trendingShows = $trendingShows;
        $this->genres = $genres;
    }

    public function getTrendingShows()
    {
        return collect($this->trendingShows)->filter(function ($show) {
            // Filter for only shows with rating greater than 5
            return (int) $show['vote_average'] >= 5;
        })->map(function ($show) {
            $genresFormatted = collect($show['genre_ids'])
                ->map(function ($genre) {
                    return genres()[$genre] ?? null;
                })
                ->filter()
                ->implode(', ');

            return collect($show)->merge([
                'original_title' => $show['original_name'],
                'backdrop_path' => 'https://image.tmdb.org/t/p/original/' . $show['backdrop_path'],
                'release_date' => Carbon::parse($show['first_air_date'])->format('Y F'),
                'vote_average' => round($show['vote_average'], 1),
                'genres' => $genresFormatted,
            ]);
        });
    }
}
