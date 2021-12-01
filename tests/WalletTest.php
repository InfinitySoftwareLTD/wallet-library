<?php namespace InfinitySolution\Wallet\Tests;

use InfinitySolution\Wallet\Transaction;
use InfinitySolution\Wallet\Wallet;
use Orchestra\Testbench\TestCase;


class WalletTest extends TestCase{

    public function test_it_returns_created_wallet()
    {
        $wallet = (new Wallet)->generateWallet();
        $this->assertArrayHasKey('passphrase', $wallet, "Array doesn't contains 'passphrase' as key");
        $this->assertArrayHasKey('pubkey', $wallet, "Array doesn't contains 'pubkey' as key");
        $this->assertArrayHasKey('address', $wallet, "Array doesn't contains 'address' as key");
    }

    public function test_it_returns_signed_transfer_testnet_transaction()
    {

        $wallet = (new Wallet)->generateWallet();

        $data = [
            'fee' => 1001,
            'amount' => 100000000,
            'passphrase' => $wallet['passphrase'],
            'recipient' => $wallet['address'],
        ];

        $sign_transaction = (new Transaction(new \InfinitySolution\Wallet\Transaction\Transfer));
        $sign_transaction->data($data);
        $sign_transaction->network('Testnet');
        $sign_transaction->server('infinity');
        $tx = $sign_transaction->build();

        $this->assertIsArray($tx);
    }

    public function test_it_returns_signed_transfer_devnet_transaction()
    {
        $wallet = (new Wallet)->generateWallet();

        $data = [
            'fee' => 1001,
            'amount' => 100000000,
            'passphrase' => $wallet['passphrase'],
            'recipient' => $wallet['address'],
        ];

        $sign_transaction = (new Transaction(new \InfinitySolution\Wallet\Transaction\Transfer));
        $sign_transaction->data($data);
        $sign_transaction->network('Devnet');
        $sign_transaction->server('infinity');
        $tx = $sign_transaction->build();

        $this->assertIsArray($tx);
    }

    public function test_it_returns_signed_transfer_mainnet_transaction()
    {

        $wallet = (new Wallet)->generateWallet();

        $data = [
            'fee' => 1001,
            'amount' => 100000000,
            'passphrase' => $wallet['passphrase'],
            'recipient' => $wallet['address'],
        ];

        $sign_transaction = (new Transaction(new \InfinitySolution\Wallet\Transaction\Transfer));
        $sign_transaction->data($data);
        $sign_transaction->network('Mainnet');
        $sign_transaction->server('infinity');
        $tx = $sign_transaction->build();

        $this->assertIsArray($tx);
    }

    public function test_it_returns_signed_transfer_devnet_hedge_transaction()
    {

        $wallet = (new Wallet)->generateWallet();

        $data = [
            'fee' => 1001,
            'amount' => 100000000,
            'passphrase' => $wallet['passphrase'],
            'recipient' => $wallet['address'],
        ];

        $sign_transaction = (new Transaction(new \InfinitySolution\Wallet\Transaction\Transfer));
        $sign_transaction->data($data);
        $sign_transaction->network('Devnet');
        $sign_transaction->server('hedge');
        $tx = $sign_transaction->build();

        $this->assertIsArray($tx);
    }

    public function test_it_returns_signed_transfer_testnet_hedge_transaction()
    {

        $wallet = (new Wallet)->generateWallet();

        $data = [
            'fee' => 1001,
            'amount' => 100000000,
            'passphrase' => $wallet['passphrase'],
            'recipient' => $wallet['address'],
        ];

        $sign_transaction = (new Transaction(new \InfinitySolution\Wallet\Transaction\Transfer));
        $sign_transaction->data($data);
        $sign_transaction->network('Testnet');
        $sign_transaction->server('hedge');
        $tx = $sign_transaction->build();

        $this->assertIsArray($tx);
    }

    public function test_it_returns_signed_transfer_mainnet_hedge_transaction()
    {

        $wallet = (new Wallet)->generateWallet();

        $data = [
            'fee' => 1001,
            'amount' => 100000000,
            'passphrase' => $wallet['passphrase'],
            'recipient' => $wallet['address'],
        ];

        $sign_transaction = (new Transaction(new \InfinitySolution\Wallet\Transaction\Transfer));
        $sign_transaction->data($data);
        $sign_transaction->network('Mainnet');
        $sign_transaction->server('hedge');
        $tx = $sign_transaction->build();

        $this->assertIsArray($tx);
    }
}
