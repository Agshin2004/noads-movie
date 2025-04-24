<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class SearchDropdown extends Component
{
    public $searchQuery;
    public $searchResults = [];
    public $movieOrTv = 'movie';  // movie OR tv
    private string $apiKey;
    private string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('moviedb.api_key');
        $this->baseUrl = config('moviedb.base_url');
    }

    public function render()
    {
        if (strlen($this->searchQuery) >= 3) {
            if ($this->movieOrTv === 'movie') {
                $this->searchResults = Http::withToken($this->apiKey)
                    ->get("$this->baseUrl/search/movie?query=$this->searchQuery")
                    ->json()['results'];
            } else {
                $this->searchResults = Http::withToken($this->apiKey)
                    ->get("$this->baseUrl/search/tv?query=$this->searchQuery")
                    ->json()['results'];
            }
        }

        return view('livewire.search-dropdown', [
            'searchResults' => $this->searchResults,
            'movieOrTv' => $this->movieOrTv
        ]);
    }
}
