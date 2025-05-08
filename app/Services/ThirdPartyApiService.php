<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Exceptions\ExternalApiException;
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

    public function patch()
    {
        // IMPLEMENT
    }

    public function delete()
    {
        // IMPLEMENT
    }
}
