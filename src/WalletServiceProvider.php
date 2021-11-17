<?php namespace InfinitySolution\Wallet;

use Illuminate\Support\ServiceProvider;

class WalletServiceProvider extends ServiceProvider{

    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('wallet', function(){
            return new Wallet();
        });
    }
}