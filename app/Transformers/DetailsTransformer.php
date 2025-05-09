<?php

namespace App\Transformers;

class DetailsTransformer implements Transformer
{
    public static function transform(array $details)
    {
        $genres = collect($details['genres'])->map(function ($genre) {
            return $genre['name'];
        });
        $voteAverage = round($details['vote_average'], 1);

        return collect($details)->merge([
            'genres' => $genres,
            'vote_average' => $voteAverage
        ])->only([
            'id',
            'backdrop_path',
            'poster_path',
            'production_countries',
            'original_title',
            'title',
            'overview',
            'release_date',
            'runtime',
            'tagline',
            'vote_average',
            'vote_count',
            // TV RELATED DETAILS
            'name',
            'original_name',
            'number_of_episodes',
            'number_of_seasons',
            'seasons',
            'status',
            'created_by',
            'episode_run_time',
            'first_air_date',
            'genres',
            'last_air_date',
        ]);
    }
}
