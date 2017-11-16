<?php

namespace Laraketai\Mobizon;

use Illuminate\Support\ServiceProvider;

class MobizonServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(MobizonApi::class, function () {
            $config = config('services.mobizon');

            return new MobizonApi($config['alphaname'], $config['secret']);
        });
    }
}
