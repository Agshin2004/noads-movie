<?php

namespace App\ViewModels;

use Illuminate\Support\Carbon;
use Spatie\ViewModels\ViewModel;


/**
 * View Models are simple classes that take some data, and transform it into something usable for the view
 * Views ideally should not have complex logic inside them, that's why I decided to use View Models
 * note: I do not make use of any ViewModel's feature as of now but I will later.
 */
class SingleMovieViewModel extends ViewModel
{
    private $movie;

    public function __construct(array $movie)
    {
        $this->movie = $movie;
    }

    private function formatGenres()
    {
        $genresArr = $this->movie['genres']; // [28 => 'Action']

        // Return only name of genre
        return collect($genresArr)->map(function ($genre) {
            return $genre['name'];
        });
    }

    private function formatCast()
    {
        // Could use laravel collection ($collection->take(5)) but decided to use php built in.
        return array_slice($this->movie['credits']['cast'], 0, 5);
    }

    private function formatImages()
    {
        // shuffle images array
        shuffle($this->movie['images']['backdrops']);
        // Could use laravel collection ($collection->take(5)) but decided to use php built in.
        return array_slice($this->movie['images']['backdrops'], 0, 5);
    }

    private function formatOriginCountry()
    {
        return collect($this->movie['origin_country'])->map(function ($country) {
            return countries()[$country] ?? '';
        })->implode(', ');
    }

    public function getMovie()
    {


        return collect($this->movie)->merge([
            'poster_path' => "https://image.tmdb.org/t/p/original/" . $this->movie['poster_path'],
            'release_date' => Carbon::parse($this->movie['release_date'])->format('Y F'),
            'vote_average' => round($this->movie['vote_average'], 1),
            'origin_country' => $this->formatOriginCountry(),
            'genres' => $this->formatGenres(),
            'credits' => $this->formatCast(),
            'images' => $this->formatImages()
        ]);
    }
}
