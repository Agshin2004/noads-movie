<?php

namespace App\Http\Controllers;

use App\ViewModels\SingleShowViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShowsController extends Controller
{
    private string $apiKey;
    private string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('moviedb.api_key');
        $this->baseUrl = config('moviedb.base_url');
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {}

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
    public function show(string $id)
    {
        $tvDetails = Http::withToken($this->apiKey)
            ->get(
                "$this->baseUrl/tv/$id?append_to_response=videos,credits,images"
            )
            ->json();
        $viewModel = new SingleShowViewModel($tvDetails);


        // Get Show Trailer
        $trailerKey = null;
        foreach ($tvDetails['videos']['results'] as $video) {
            if ($video['type'] === 'Trailer') {
                $trailerKey = $video['key'];
            }
        }

        // Type
        $type = 'tv';

        return view('single-show', [
            'tvId' => $tvDetails['id'],
            'tvShow' => $viewModel->getShow(),
            'trailerKey' => $trailerKey,
            'type' => $type
        ]);
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
