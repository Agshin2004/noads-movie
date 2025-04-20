<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class SearchDropdown extends Component
{
    public $searchQuery;
    public $searchResults = [];
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
            $this->searchResults = Http::withToken($this->apiKey)
            ->get("$this->baseUrl/search/movie?query=$this->searchQuery->$")
            ->json()['results'];
        }


        return view('livewire.search-dropdown', [
            'searchResults' => $this->searchResults
        ]);
    }
}
