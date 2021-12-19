<?php namespace InfinitySolution\Wallet;

use Illuminate\Support\ServiceProvider;
use InfinitySolution\Wallet\Peer;

class PeerServiceProvider extends ServiceProvider{

    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('peer', function(){
            return new Peer();
        });
    }
}