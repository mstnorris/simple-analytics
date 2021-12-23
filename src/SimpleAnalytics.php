<?php

namespace Mstnorris\SimpleAnalytics;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class SimpleAnalytics
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function call($uri = null, $params = [], $method = 'GET'): ResponseInterface
    {
        $uri ??= sprintf('%s.json', config('simple-analytics.website'));

        $defaultParams = [
            'query' => [
                'version' => config('simple-analytics.api-version', 5),
                'fields'  => 'visitors',
                'info'    => 'false',
                'start'   => '2021-11-17',
                'end'     => '2021-12-17'
            ]
        ];

        return $this->client->request($method, $uri, array_merge($defaultParams, $params));
    }

    public function stats(): ResponseInterface
    {
        return $this->call();
    }

    public function today(): ResponseInterface
    {
        $params = [
            'query' => [
                'start'   => now()->toDateString(),
                'end'     => now()->toDateString()
            ]
        ];
        return $this->call(null, $params);
    }

}
