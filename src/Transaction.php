<?php 

namespace InfinitySolution\Wallet;

use InfinitySolution\Wallet\TransactionContract;

class Transaction{

    protected $contract;

    public function setTransaction(TransactionContract $contract)
    {
        $this->contract = $contract;
        return $this;
    }

    public function blockchain($server): Transaction
    {
        $this->contract->blockchain($server);
        return $this;
    }

    public function network($network): Transaction
    {
        $this->contract->network($network);
        return $this;
    }

    public function data($data): Transaction
    {
        $this->contract->data($data);
        return $this;
    }

    public function build()
    {
        return $this->contract->build();
    }

    public function peer($peer): Transaction
    {
        $this->contract->peer($peer);
        return $this;
    }

    public function protocol($protocol): Transaction
    {
        $this->contract->protocol($protocol);
        return $this;
    }
}
