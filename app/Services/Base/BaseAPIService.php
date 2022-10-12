<?php

namespace App\Services\Base;

use Psr\Http\Client\ClientInterface;

abstract class BaseAPIService
{
    protected $http;

    abstract public static function getBaseUrl() : string;

    public function __construct(ClientInterface $httpClient)
    {
        $this->http = $httpClient;
    }

    protected function generateEndpoint(string $endpoint) : string
    {
        return sprintf($this->getBaseUrl() . '/%s', $endpoint);
    }
}
