<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ThirdPartyApiService;
use App\Transformers\DetailsTransformer;
use App\Transformers\GeneralTransofmer;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ThirdPartyApiService $api)
    {
        $response = $api->get('trending/movie/week');

        $data = GeneralTransofmer::transform($response);

        return $this->successResponse($data, code: 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, ThirdPartyApiService $api)
    {
        $response = $api->get("movie/{$id}?append_to_response=videos,credits,images");
        $data = DetailsTransformer::transform($response);
        return $this->successResponse($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
