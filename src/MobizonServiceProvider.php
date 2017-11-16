<?php

namespace Laraketai\Mobizon;

use Illuminate\Support\ServiceProvider;
use Mobizon\MobizonApi;


class MobizonServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/mobizon.php' => config_path('mobizon.php') . "/"
        ], 'config');
    }

    public function register()
    {
        $this->app->singleton(Mobizon::class, function () {
            $config = config('mobizon');

            return new Mobizon($config['secret']);
        });

        $this->app->singleton(MobizonApi::class, function () {
            $config = config('mobizon');

            return new MobizonApi($config['secret']);
        });
    }

}
