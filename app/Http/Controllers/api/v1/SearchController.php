<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Services\ThirdPartyApiService;
use App\Transformers\TrendingTransformer;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request, ThirdPartyApiService $api)
    {
        $mediaType = $request->query('type');
        $search = $request->query('search');
        if (!$mediaType || !$search) {
            throw new \Exception('type query param or search query not specified', 400);
        }

        if ($mediaType === 'person') {
            // Added simple if check here, to not  create new transformer class if person is being search
            return $api->get('search/person', [
                'query' => urlencode($search),
            ]);
        }

        $response = $api->get("search/{$mediaType}", [
            'query' => urlencode($search),
        ]);
        $data = TrendingTransformer::transform($response);

        return $this->successResponse($data);
    }
}
