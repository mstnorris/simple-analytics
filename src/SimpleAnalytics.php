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
                'start'   => now()->subMonth()->toDateString(),
                'end'     => now()->endOfDay()->toDateString()
            ]
        ];

        return $this->client->request($method, $uri, array_replace_recursive($defaultParams, $params));
    }

    public function stats(): ResponseInterface
    {
        return $this->call();
    }

    public function today(): int
    {
        $params = [
            'query' => [
                'start'   => now()->startOfDay()->toDateString(),
                'end'     => now()->endOfDay()->toDateString()
            ]
        ];

        $response = $this->call(null, $params);

        return json_decode($response->getBody(), true)['visitors'];
    }

}
