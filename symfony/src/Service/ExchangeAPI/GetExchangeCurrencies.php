<?php

namespace App\Service\ExchangeAPI;

use App\Service\Utils\HttpClientInterface;

class GetExchangeCurrencies
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function __invoke()
    {
    }
}