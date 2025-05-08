<?php

namespace App\Exceptions;

use Exception;

class ExternalApiException extends Exception
{
    protected string $endpoint;
    protected array $responseData;

    public function __construct(string $message = '', int $code = 0, string $endpoint = '', array $responseData = [])
    {
        parent::__construct($message, $code);

        $this->endpoint = $endpoint;
        $this->responseData = $responseData;
    }

    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function getResponseData()
    {
        return $this->responseData;
    }
}
