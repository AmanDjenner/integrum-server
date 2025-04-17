<?php

use \Illuminate\Support\ServiceProvider;

/**
 * Własny system AuthRest
 *
 * @author karolsz
 */
class AuthRestServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app['authrest'] = $this->app->share(function($app) {
            return new AuthRest;
        });
    }
}