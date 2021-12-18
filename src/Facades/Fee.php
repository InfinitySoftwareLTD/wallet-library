<?php namespace InfinitySolution\Wallet\Facades;

use Illuminate\Support\Facades\Facade;

class Fee extends Facade{

    protected static function getFacadeAccessor()
    {
        return 'fee';
    }

}