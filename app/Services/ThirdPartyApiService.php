<?php

namespace App\Services;

use App\Exceptions\ExternalApiException;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

// This service will be binded as singletong
class ThirdPartyApiService
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
        // NOTE: sometimes when $query is empty and endpoint excepts must have queries
        // if queries are not specified in $query it won't work
        $response = Http::withToken($this->token)
            ->get("{$this->baseUrl}/{$endpoint}", $query)  // laravel will automatically encode query params
            ->json();

        if (isset($response['success']) && !$response['success']) {
            throw new ExternalApiException($response['status_message'], 404, $endpoint, $response);
        }

        return $response;
    }

    public function post(string $endpoint, array $data = [])
    {
        return Http::withToken($this->token)
            ->post("{$this->baseUrl}/{$endpoint}", $data)
            ->json();
    }
}
