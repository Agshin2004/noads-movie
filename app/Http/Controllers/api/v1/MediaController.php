<?php

namespace App\Http\Controllers\api\v1;

use App\Enums\Players;
use App\Http\Controllers\Controller;
use App\Services\ThirdPartyApiService;
use App\Transformers\GeneralTransofmer;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    protected ThirdPartyApiService $api;

    public function __construct(ThirdPartyApiService $api)
    {
        $this->api = $api;
    }

    public function search(Request $request)
    {
        $mediaType = $request->query('type');
        $search = $request->query('search');
        $page = $request->input('page', 1);

        if (!in_array($mediaType, mediaTypes()) || !$search) {
            throw new \Exception('Media type is not specified or is invalid (movie, tv)', 400);
        }

        if ($mediaType === 'person') {
            // Added simple if check here, to not  create new transformer class if person is being search
            return $this->api->get('search/person', [
                'query' => urlencode($search),
                'page' => $page
            ]);
        }

        $response = $this->api->get("search/{$mediaType}", [
            'query' => urlencode($search),
            'page' => $page
        ]);
        $data = GeneralTransofmer::transform($response);

        return $this->successResponse($data);
    }

    public function popular(Request $request)
    {
        $mediaType = $request->query('type');
        $page = $request->input('page', 1);

        if (!in_array($mediaType, mediaTypes())) {
            throw new \Exception('Media type is not specified or is invalid (movie, tv)', 400);
        }

        $response = $this->api->get("{$mediaType}/popular", ['page' => $page]);
        return $this->successResponse($response);
    }

    public function nowPlaying(Request $request)
    {
        $mediaType = $request->query('type');
        $page = $request->input('page', 1);

        if ($mediaType === 'movie') {
            $response = $this->api->get('movie/now_playing', ['page' => $page]);
        } else if ($mediaType === 'tv') {
            $response = $this->api->get('tv/on_the_air', ['page' => $page]);
        } else {
            throw new \Exception('Media type is not specified.', 400);
        }

        return $this->successResponse($response);
    }

    public function filter(Request $request)
    {
        $mediaType = $request->query('type');
        $genres = $request->query('genres');
        $releaseDateGte = $request->query('releaseDate')['gte'] ?? null;  // gte must be passed as nested array (releaseDate[gte]) so laravel can parse it into ["releaseDate" => ["gte" => <date>]]
        $releaseDateLte = $request->query('releaseDate')['lte'] ?? null;
        $year = $request->query('year');
        $country = $request->query('country');
        $sortBy = $request->query('sortBy');
        $page = $request->input('page', 1);

        if (!in_array($mediaType, mediaTypes()))
            throw new \Exception('Media type is not specified or specified wrong. Options > (movie or tv)', 400);

        if (!$genres && !$releaseDateGte && !$releaseDateLte && !$year && !$country)
            throw new \Exception('At least one filter param must be specified (genres, year or releaseDate)', 400);

        if (!in_array($sortBy, sortingOptions()))
            throw new \Exception(
                "{$sortBy} is not valid sorting options, available >>> " . implode(', ', sortingOptions()),
                400
            );

        $response = $this->api->get("discover/{$mediaType}", [
            'with_genres' => $genres,
            'year' => $year,
            'release_date.gte' => $releaseDateGte,
            'release_date.lte' => $releaseDateLte,
            'with_origin_country' => strtoupper($country),
            'sort_by' => $sortBy,
            'page' => $page
        ]);
        $data = $this->successResponse($response);
        return $data;
    }

    public function topRated(Request $request)
    {
        $mediaType = $request->query('type');
        $page = $request->input('page', 1);

        if (!in_array($mediaType, mediaTypes()))
            throw new \Exception('Media type is not specified or is invalid (movie, tv)', 400);

        $response = $this->api->get("{$mediaType}/top_rated", ['page' => $page]);
        $data = $this->successResponse($response);
        return $data;
    }

    public function players(Request $request)
    {
        $option = $request->query('option');

        $playerNames = array_map(fn($case) => $case->name, Players::cases());
        if ($option && !in_array($option, $playerNames))
            throw new \Exception(
                'Option is not valid; Availabled options >>> ' . implode(', ', $playerNames),
                400
            );
        $filteredPlayer = collect(Players::cases())->first(function ($case) use ($option) {
            return $case->name === $option;
        });
        return $this->successResponse([
            (!$option ? 'players' : 'player') => (!$option ? Players::cases() : $filteredPlayer->value)
        ]);
    }

    public function recommendations(Request $request)
    {
        $mediaType = $request->query('type');
        $mediaId = $request->query('id');
        if (!in_array($mediaType, mediaTypes()))
            throw new \Exception('type and id must be specified', 400);

        $response = $this->api->get("{$mediaType}/{$mediaId}/recommendations");
        return $this->successResponse($response);
    }
}
