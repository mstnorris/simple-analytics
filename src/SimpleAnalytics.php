<?php

namespace Mstnorris\SimpleAnalytics;

use GuzzleHttp\Client;

class SimpleAnalytics
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function stats(): string
    {
        $uri = sprintf('%s.json', config('simple-analytics.website'));

        $params = [
            'version' => config('simple-analytics.api-version', 5),
            'fields' => 'histogram',
            'info' => false,
            'start' => '2021-11-17',
            'end' => '2021-12-17'
        ];

        $response = $this->client->request('GET', $uri, $params);

        return json_encode($response);
    }

}
