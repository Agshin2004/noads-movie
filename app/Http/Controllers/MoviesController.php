<?php

namespace App\Http\Controllers;

use App\ViewModels\MoviesViewModel;
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
        $popularMovies = Http::withHeaders([
            'Authorization' => "Bearer $this->apiKey",
            'Accept' => 'application/json',
        ])
            ->get("$this->baseUrl/movie/popular")
            ->json()['results'];
        $genres = Http::withHeaders([
            'Authorization' => "Bearer $this->apiKey",
            'Accept' => 'application/json'
        ])
            ->get("$this->baseUrl/genre/movie/list")
            ->json()['genres'];

        // $genresName = [];
        // foreach ($genres as $genre) {
        //     $genresName[$genre['id']] = $genre['name'];
        // }

        
        $viewModel = new MoviesViewModel($popularMovies, $genres);
        dump($viewModel->getPopularMovies());

        return view('home', [
            'movies' => $viewModel->getPopularMovies(),
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
        // TODO: Make reusable
        $genres = Http::withHeaders([
            'Authorization' => "Bearer $this->apiKey",
            'Accept' => 'application/json'
        ])
            ->get("$this->baseUrl/genre/movie/list")
            ->json()['genres'];

        // Movie Genres
        $genresName = [];
        foreach ($genres as $genre) {
            $genresName[$genre['id']] = $genre['name'];
        }
        dump($movieDetails);

        // Get Movie Trailer
        $trailerKey = null;
        foreach ($movieDetails['videos']['results'] as $video) {
            if ($video['type'] === 'Trailer') {
                $trailerKey= $video['key'];
            }
        }

        return view('single-movie', [
            'movie' => $movieDetails,
            'genresName' => $genresName,
            'trailerKey' => $trailerKey
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
