<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Services\ThirdPartyApiService;
use App\Transformers\GeneralTransofmer;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function search(Request $request, ThirdPartyApiService $api)
    {
        $mediaType = $request->query('type');
        $search = $request->query('search');
        $page = $request->query('page') ?? 1;  // if page is not specified default to 1

        if (!in_array($mediaType, mediaTypes()) || !$search) {
            throw new \Exception('Media type is not specified or is invalid (movie, tv)', 400);
        }

        if ($mediaType === 'person') {
            // Added simple if check here, to not  create new transformer class if person is being search
            return $api->get('search/person', [
                'query' => urlencode($search),
                'page' => $page
            ]);
        }

        $response = $api->get("search/{$mediaType}", [
            'query' => urlencode($search),
            'page' => $page
        ]);
        $data = GeneralTransofmer::transform($response);

        return $this->successResponse($data);
    }

    public function popular(Request $request, ThirdPartyApiService $api)
    {
        $mediaType = $request->query('type');
        $page = $request->query('page') ?? 1;

        if (!in_array($mediaType, mediaTypes())) {
            throw new \Exception('Media type is not specified or is invalid (movie, tv)', 400);
        }

        $response = $api->get("{$mediaType}/popular", ['page' => $page]);
        return $this->successResponse($response);
    }

    public function nowPlaying(Request $request, ThirdPartyApiService $api)
    {
        $mediaType = $request->query('type');
        $page = $request->query('page') ?? 1;

        if ($mediaType === 'movie') {
            $response = $api->get('movie/now_playing', ['page' => $page]);
        } else if ($mediaType === 'tv') {
            $response = $api->get('tv/on_the_air', ['page' => $page]);
        } else {
            throw new \Exception('Media type is not specified.', 400);
        }

        return $this->successResponse($response);
    }

    public function filter(Request $request, ThirdPartyApiService $api)
    {
        $sortOptions = [
            $$request->query('sortPopularity')['asc'],
            $request->query('sortPopularity')['desc'],
            $request->query('sortVoteAverage')['asc'],
            $request->query('sortVoteAverage')['desc'],
            $request->query('sortReleaseDate')['asc'],
            $request->query('sortReleaseDate')['desc']
        ];
        $sortBy = collect($sortOptions)->filter()->keys();
        dd($sortBy);

        $mediaType = $request->query('type');
        $genres = $request->query('genres');
        $releaseDateGte = $request->query('releaseDate')['gte'] ?? null;  // gte must be passed as nested array (releaseDate[gte]) so laravel can parse it into ["releaseDate" => ["gte" => <date>]]
        $releaseDateLte = $request->query('releaseDate')['lte'] ?? null;
        $year = $request->query('year');
        $country = $request->query('country');

        if (!in_array($mediaType, mediaTypes()))
            throw new \Exception('Media type is not specified or specified wrong. Options > (movie or tv)', 400);

        if (!$genres && !$releaseDateGte && !$releaseDateLte && !$year && !$country)
            throw new \Exception('At least one filter param must be specified (genres, year or releaseDate)', 400);

        return $api->get("discover/{$mediaType}", [
            'with_genres' => $genres,
            'year' => $year,
            'release_date.gte' => $releaseDateGte,
            'release_date.lte' => $releaseDateLte,
            'with_origin_country' => strtoupper($country),
        ]);
    }

    public function topRated(Request $request, ThirdPartyApiService $api)
    {
        $mediaType = $request->query('type');
        $page = $request->query('page') ?? 1;

        if (!in_array($mediaType, mediaTypes())) {
            throw new \Exception('Media type is not specified or is invalid (movie, tv)', 400);
        }

        $response = $api->get("{$mediaType}/top_rated", ['page' => $page]);
        $data = $this->successResponse($response);
        return $data;
    }
}
