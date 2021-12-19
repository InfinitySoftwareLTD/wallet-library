<?php namespace InfinitySolution\Wallet\Facades;

use Illuminate\Support\Facades\Facade;

class Peer extends Facade{

    protected static function getFacadeAccessor()
    {
        return 'peer';
    }

}