<?php

namespace VerifyID\Laravel;

use Illuminate\Support\ServiceProvider;
use VerifyID\VerifyID;

class VerifyIDServiceProvider extends ServiceProvider
{
    /**
     * Register the VerifyID singleton in the Laravel service container.
     */
    public function register()
    {
        $this->app->singleton(VerifyID::class, function ($app) {
            $apiKey = config('verifyid.api_key') ?? env('VERIFYID_API_KEY');
            $baseUrl = config('verifyid.base_url') ?? null;
            return new VerifyID($apiKey, $baseUrl);
        });
    }

    /**
     * Boot method: Publishes the config file.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/verifyid.php' => config_path('verifyid.php'),
        ], 'verifyid-config');
    }
}
