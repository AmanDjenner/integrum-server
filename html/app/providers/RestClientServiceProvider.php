<?php

use \Illuminate\Support\ServiceProvider;

class RestClientServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app['restclient'] = $this->app->share(function($app) {
            return new RestClient;
        });
    }
}