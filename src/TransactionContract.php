<?php namespace InfinitySolution\Wallet;

interface TransactionContract{

    public function server(string $server);

    public function network(string $network);

    public function data(array $data);

    public function build();
}
