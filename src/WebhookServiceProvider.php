<?php namespace InfinitySolution\Wallet;

use Illuminate\Support\ServiceProvider;

class WebhookServiceProvider extends ServiceProvider{

    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('webhook', function(){
            return new Webhook;
        });
    }
}