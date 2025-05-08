<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

// This service will be binded as singletong
class ThirdPartyApiSerivce
{
    protected string $token;
    protected string $baseUrl;

    public function __construct()
    {
        $this->token = config('moviedb.api_key');
        $this->baseUrl = config('moviedb.base_url');
    }

    public function get(string $endpoint, array $query = [])
    {
        return Http::withToken($this->token)
            ->get("{$this->baseUrl}/{$endpoint}", $query)  // laravel will automatically encode query params
            ->json();
    }

    public function post(string $endpoint, array $data = [])
    {
        return Http::withToken($this->token)
            ->post("{$this->baseUrl}/{$endpoint}", $data)
            ->json();
    }
}
