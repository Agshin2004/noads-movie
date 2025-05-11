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
        $page = $request->query('page');
        if (!$mediaType || !$search) {
            throw new \Exception('type query param or search query not specified', 400);
        }

        if ($mediaType === 'person') {
            // Added simple if check here, to not  create new transformer class if person is being search
            return $api->get('search/person', [
                'query' => urlencode($search),
                'page' => $page ?? 1  // if page is not specified default to 1
            ]);
        }

        $response = $api->get("search/{$mediaType}", [
            'query' => urlencode($search),
            'page' => $page ?? 1  // if page is not specified default to 1
        ]);
        $data = GeneralTransofmer::transform($response);

        return $this->successResponse($data);
    }

    public function popular(Request $request, ThirdPartyApiService $api)
    {
        $mediaType = $request->query('type');
        $page = $request->query('page');

        if (!$mediaType) {
            throw new \Exception('type query param not specified', 400);
        }

        $response = $api->get("{$mediaType}/popular", ['page' => $page ?? 1]);
        return $this->successResponse($response);
    }

    public function nowPlaying(Request $request, ThirdPartyApiService $api)
    {
        $mediaType = $request->query('type');
        $page = $request->query('page');
        if ($mediaType === 'movie') {
            $response = $api->get('movie/now_playing', ['page' => $page]);
        } else if ($mediaType === 'tv') {
            $response = $api->get('tv/on_the_air', ['page' => $page]);
        } else {
            throw new \Exception('Media type is not specified.', 400);
        }
        return $this->successResponse($response);
    }
}
