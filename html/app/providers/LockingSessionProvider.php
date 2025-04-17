<?php

use \Illuminate\Support\ServiceProvider;
use \Illuminate\Cache\Repository;
use Igormatkovic\Memcache\MemcacheStore;
use Igormatkovic\Memcache\MemcacheConnector;

class LockingSessionProvider extends ServiceProvider
{

    public function register()
    {
        Session::extend('memcache', function($app)
        {
            $servers = $this->app['config']['cache.memcached'];
            $prefix = $this->app['config']['cache.prefix'];
            $minutes = $this->app['config']['session.lifetime'];
            $memcacheConn = new MemcacheConnector();
            $memcache = $memcacheConn->connect($servers);
            $repo = new Repository(new MemcacheStore($memcache, $prefix));
            $handler = new Igormatkovic\Memcache\MemcacheHandler($repo, $minutes);
            $manager = new Igormatkovic\Memcache\MemcacheSessionManager($handler);
            return $manager->driver('memcache');
        });
        Session::extend('filelock', function($app)
            {
                return new LockingSessionHandler();
            });
    }
}