<?php

namespace Mstnorris\SimpleAnalytics;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class SimpleAnalyticsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected bool $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/simple-analytics.php' => config_path('simple-analytics.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(SimpleAnalytics::class, function () {
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

            return new SimpleAnalytics($client);
        });
    }

    public function provides(): array
    {
        return [SimpleAnalytics::class];
    }

}
