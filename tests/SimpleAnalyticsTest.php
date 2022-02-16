<?php

namespace Mstnorris\SimpleAnalytics\Tests;

use GuzzleHttp\Client;
use Mstnorris\SimpleAnalytics\SimpleAnalytics;

class SimpleAnalyticsTest extends TestCase
{
    /**
     * can get stats
     *
     * @return void
     */
    public function testCanGetStats()
    {
        $baseUri = config('simple-analytics.base-uri', 'https://simpleanalytics.com');
        $userId = config('simple-analytics.user-id');
        $apiKey = config('simple-analytics.api-key');

        $client = new Client([
            'http_errors' => false,
            'base_uri'    => rtrim($baseUri, "/"),
            'headers'     => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
                'User-Id'      => $userId,
                'Api-Key'      => $apiKey,
            ],
        ]);

        $sa = new SimpleAnalytics($client);

        // fussyfork.com/2bdd63b4-3b43-4122-8871-bef66141864f
        $response = $sa->call('https://simpleanalytics.com/simpleanalytics.com.json?version=5&fields=histogram&info=false&start=2021-11-17&end=2021-12-31');

        var_dump($response->getBody());
        // var_dump($sa->stats());

    }
    /**
     * it checks true
     *
     * @return void
     */
    public function testItChecksTrue(): void
    {
        $this->assertTrue(true);
    }
}
