<?php

namespace App\ViewModels;

use Illuminate\Support\Carbon;
use Spatie\ViewModels\ViewModel;

class SingleShowViewModel extends ViewModel
{
    private $show;

    public function __construct(array $show)
    {
        $this->show = $show;
    }

    public function getShow()
    {
        return collect($this->show)->merge([
            'poster_path' => 'https://image.tmdb.org/t/p/w780/' . $this->show['poster_path'],
            'release_date' => Carbon::parse($this->show['first_air_date'])->format('Y F'),
            'vote_average' => round($this->show['vote_average'], 1),
            'origin_country' => $this->formatOriginCountry(),
            'genres' => $this->formatGenres(),
            'credits' => $this->formatCast(),
            'images' => $this->formatImages()
        ]);
    }

    private function formatGenres()
    {
        $genresArr = $this->show['genres'];  // [28 => 'Action']

        // Return only name of genre
        return collect($genresArr)->map(function ($genre) {
            return $genre['name'];
        });
    }

    private function formatCast()
    {
        // Could use laravel collection ($collection->take(5)) but decided to use php built in.
        return array_slice($this->show['credits']['cast'], 0, 5);
    }

    private function formatImages()
    {
        // shuffle images array
        shuffle($this->show['images']['backdrops']);
        // Could use laravel collection ($collection->take(5)) but decided to use php built in.
        return array_slice($this->show['images']['backdrops'], 0, 5);
    }

    private function formatOriginCountry()
    {
        return collect($this->show['origin_country'])->map(function ($country) {
            return countries()[$country] ?? '';
        })->implode(', ');
    }

}
