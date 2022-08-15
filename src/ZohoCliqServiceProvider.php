<?php

namespace NotificationChannels\ZohoCliq;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;

class ZohoCliqServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Bootstrap code here.

        $this->app->when(ZohoCliqChannel::class)
            ->needs(ZohoCliq::class)
            ->give(static function () {
                return new ZohoCliq(
                    new HttpClient()
                );
            });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        Notification::extend('zohoCliq', static function (Container $app) {
            return $app->make(ZohoCliqChannel::class);
        });
    }
}
