<?php namespace InfinitySolution\Wallet\Facades;

use Illuminate\Support\Facades\Facade;

class Transaction extends Facade{

    protected static function getFacadeAccessor()
    {
        return 'transaction';
    }

}