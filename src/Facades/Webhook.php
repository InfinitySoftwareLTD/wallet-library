<?php namespace InfinitySolution\Wallet\Facades;

use Illuminate\Support\Facades\Facade;

class Webhook extends Facade{

    protected static function getFacadeAccessor()
    {
        return 'webhook';
    }

}