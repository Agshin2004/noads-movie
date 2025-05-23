<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Services\ThirdPartyApiService;
use App\Transformers\DetailsTransformer;
use App\Transformers\GeneralTransofmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class MoviesController extends Controller
{
    protected ThirdPartyApiService $api;

    public function __construct(ThirdPartyApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $response = $this->api->get('trending/movie/week');
        $data = GeneralTransofmer::transform($response);
        return $this->successResponse($data);
    }

    public function show(Request $request, string $id)
    {
        $response = $this->api->get("movie/{$id}?append_to_response=videos,credits,images");
        $data = DetailsTransformer::transform($response);

        return $this->successResponse(
            $data,
        );
    }

    public function addComment(Request $request)
    {
        Validator::make(
            $request->all(),
            [
                'user_id' => ['required', 'exists:\App\Models\User,id'],
                'movieOrShowId' => ['required', 'numeric'],
                'body' => ['required', 'min:4']
            ]
        );
        
    }
}
