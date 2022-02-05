<?php namespace InfinitySolution\Wallet;

interface TransactionContract{

    public function blockchain(string $server);

    public function network(string $network);

    public function data(array $data);

    public function peer(string $peer);

    public function protocol(string $protocol);

    public function build();
}
