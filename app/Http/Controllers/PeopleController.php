<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ViewModels\PeopleViewModel;
use Illuminate\Support\Facades\Http;

class PeopleController extends Controller
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
        //
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
    public function show(int $personId)
    {
        $person = Http::withToken($this->apiKey)
            ->get("$this->baseUrl/person/$personId")
            ->json();
        
        
        $movieCredits = Http::withToken($this->apiKey)
            ->get("$this->baseUrl/person/$personId/movie_credits?language=en-US")
            ->json()['cast'];

        // dump($movieCredits);
    

        $viewModel = new PeopleViewModel($person, $movieCredits);

        // TODO: Add user's TV credits (as of now only movies credits of an actor shown)

        return view('person-detail', [
            'person' => $viewModel->getPersonDetails(),
            'movieCredits' => $viewModel->getMovieCredits(),
            'links' => $viewModel->paginationLinks->links(),
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
