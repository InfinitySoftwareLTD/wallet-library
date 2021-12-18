<?php namespace InfinitySolution\Wallet;

use Illuminate\Support\ServiceProvider;

class FeeServiceProvider extends ServiceProvider{

    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('fee', function(){
            return new Fee();
        });
    }
}