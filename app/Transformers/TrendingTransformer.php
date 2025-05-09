<?php

namespace App\Transformers;

use App\Transformers\Transformer;

/**
 * This class is used as layer, json will be modified here
 */
class TrendingTransformer implements Transformer
{
    public static function transform(array $items)
    {
        return collect($items['results'])->map(function ($result) {
            $genres = makeGenresFromIds($result['genre_ids']);
            $voteAverage = round($result['vote_average'], 1);

            return collect($result)
                ->merge([
                    'genres' => $genres,
                    'vote_average' => $voteAverage,
                ])
                ->forget('genre_ids')
                ->only([
                    'id',
                    'backdrop_path',
                    'title',
                    'original_title',
                    'name',
                    'original_name',
                    'overview',
                    'poster_path',
                    'media_type',
                    'genres',
                    'original_language',
                    'release_date',
                    'first_air_date',
                    'vote_average',
                    'vote_count'
                ]);
        });
    }
}
