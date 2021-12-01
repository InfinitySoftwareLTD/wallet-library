<?php namespace InfinitySolution\Wallet;

use Illuminate\Support\ServiceProvider;

class TransactionServiceProvider extends ServiceProvider{

    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('transaction', function(){
            return new Transaction();
        });
    }
}