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

        $movieGenres = Http::withHeaders([
            'Authorization' => "Bearer $this->apiKey",
            'Accept' => 'application/json'
        ])
            ->get("$this->baseUrl/genre/movie/list")
            ->json()['genres'];

        $showsGenres = Http::withHeaders([
            'Authorization' => "Bearer $this->apiKey",
            'Accept' => 'application/json'
        ])
            ->get("$this->baseUrl/genre/tv/list")
            ->json()['genres'];

        // $genresName = [];
        // foreach ($genres as $genre) {
        //     $genresName[$genre['id']] = $genre['name'];
        // }

        $moviesViewModel = new MoviesViewModel($trendingMovies, $movieGenres);
        $showsViewModel = new ShowsViewModel($trendingShows, $showsGenres);

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

        // TODO: Make reusable
        $genres = Http::withHeaders([
            'Authorization' => "Bearer $this->apiKey",
            'Accept' => 'application/json'
        ])
            ->get("$this->baseUrl/genre/movie/list")
            ->json()['genres'];

        // Movie Genres
        $genresName = reformatGenres($genres);
        
        // dump($movieDetails);

        // Get Movie Trailer
        $trailerKey = null;
        foreach ($movieDetails['videos']['results'] as $video) {
            if ($video['type'] === 'Trailer') {
                $trailerKey = $video['key'];
            }
        }

        $viewModel = new SingleMovieViewModel($movieDetails);
    
        return view('single-movie', [
            'movie' => $viewModel->getMovie(),
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
