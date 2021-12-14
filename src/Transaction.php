<?php 

namespace InfinitySolution\Wallet;

use InfinitySolution\Wallet\TransactionContract;

class Transaction{

    protected \InfinitySolution\Wallet\TransactionContract $contract;

    public function setTransaction(TransactionContract $contract)
    {
        $this->contract = $contract;
        return $this;
    }

    public function server($server): Transaction
    {
        $this->contract->server($server);
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
}
