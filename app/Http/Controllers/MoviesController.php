<?php

namespace App\Http\Controllers;

use App\ViewModels\MoviesViewModel;
use App\ViewModels\ShowsViewModel;
use App\ViewModels\SingleMovieViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MoviesController extends Controller
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
    public function index()
    {
        // Http facade is essentially a wrapper around Guzzle
        $trendingMovies = Http::withHeaders([
            'Authorization' => "Bearer $this->apiKey",
            'Accept' => 'application/json',
        ])
            ->get("$this->baseUrl/trending/movie/week")
            ->json()['results'];

        $trendingShows = Http::withHeaders([
            'Authorization' => "Bearer $this->apiKey",
            'Accept' => 'application/json',
        ])
            ->get("$this->baseUrl/trending/tv/week")
            ->json()['results'];

        $moviesViewModel = new MoviesViewModel($trendingMovies, genres());
        $showsViewModel = new ShowsViewModel($trendingShows, genres());

        $moviesAndShows = array_merge(
            $moviesViewModel->getTrendingMovies()->toArray(),
            $showsViewModel->getTrendingShows()->toArray()
        );

        // Shuffle final merged array with movies and shows
        shuffle($moviesAndShows);

        // dump($moviesAndShows);

        return view('home', [
            'moviesAndShows' => array_slice($moviesAndShows, 0, 20),
        ]);
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
    public function show(string $id)
    {
        $movieDetails = Http::withToken($this->apiKey)->get("$this->baseUrl/movie/$id?append_to_response=videos,credits,images")->json();

        if (isset($movieDetails['success'])) {
            return abort(404);
        }

        $genres = collect($movieDetails['genres'])->map(function ($genre) {
            return genres()[$genre['id']] ?? null;
        })->filter();

        // Get Movie Trailer
        $trailerKey = null;
        foreach ($movieDetails['videos']['results'] as $video) {
            if ($video['type'] === 'Trailer') {
                $trailerKey = $video['key'];
            }
        }

        $viewModel = new SingleMovieViewModel($movieDetails);

        // Type
        $type = 'movie';

        return view('single-movie', [
            'movie' => $viewModel->getMovie(),
            'genresName' => $genres,
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
