<?php namespace InfinitySolution\Wallet\Facades;

use Illuminate\Support\Facades\Facade;

class Wallet extends Facade{

    protected static function getFacadeAccessor()
    {
        return 'wallet';
    }

}