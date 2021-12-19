<?php namespace InfinitySolution\Wallet\Tests;

use InfinitySolution\Wallet\Fee;
use InfinitySolution\Wallet\Network\Infinity\Devnet;
use InfinitySolution\Wallet\Network\Infinity\Mainnet;
use InfinitySolution\Wallet\Network\Infinity\Testnet;
use InfinitySolution\Wallet\Peer;
use InfinitySolution\Wallet\Transaction;
use InfinitySolution\Wallet\Wallet;
use InfinitySolution\Wallet\Webhook;
use Orchestra\Testbench\TestCase;


class WalletTest extends TestCase{

    public function test_it_returns_created_testnet_wallet()
    {
        $wallet = (new Wallet(new Testnet))->generateWallet();
        print_r($wallet);
        $this->assertArrayHasKey('passphrase', $wallet, "Array doesn't contains 'passphrase' as key");
        $this->assertArrayHasKey('pubkey', $wallet, "Array doesn't contains 'pubkey' as key");
        $this->assertArrayHasKey('address', $wallet, "Array doesn't contains 'address' as key");
    }

    public function test_it_returns_created_devnet_wallet()
    {
        $wallet = (new Wallet(new Devnet))->generateWallet();
        print_r($wallet);
        $this->assertArrayHasKey('passphrase', $wallet, "Array doesn't contains 'passphrase' as key");
        $this->assertArrayHasKey('pubkey', $wallet, "Array doesn't contains 'pubkey' as key");
        $this->assertArrayHasKey('address', $wallet, "Array doesn't contains 'address' as key");
    }

    public function test_it_returns_created_mainnet_wallet()
    {
        $wallet = (new Wallet(new Mainnet))->generateWallet();
        print_r($wallet);
        $this->assertArrayHasKey('passphrase', $wallet, "Array doesn't contains 'passphrase' as key");
        $this->assertArrayHasKey('pubkey', $wallet, "Array doesn't contains 'pubkey' as key");
        $this->assertArrayHasKey('address', $wallet, "Array doesn't contains 'address' as key");
    }

    public function test_it_returns_signed_transfer_testnet_transaction()
    {

        $wallet = (new Wallet(new Testnet))->generateWallet();

        $data = [
            'fee' => 1001,
            'amount' => 100000000,
            'passphrase' => $wallet['passphrase'],
            'recipient' => $wallet['address'],
            'vendor_field' => 'Example Message'
        ];

        $sign_transaction = (new Transaction);
        $sign_transaction->setTransaction(new \InfinitySolution\Wallet\Transaction\Transfer);
        $sign_transaction->data($data);
        $sign_transaction->network('Testnet');
        $sign_transaction->server('infinity');
        $tx = $sign_transaction->build();

        print_r(json_encode($tx));
        $this->assertIsArray($tx);
    }

    public function test_it_returns_signed_transfer_devnet_transaction()
    {
        $wallet = (new Wallet(new Devnet))->generateWallet();

        $data = [
            'fee' => 1001,
            'amount' => 100000000,
            'passphrase' => $wallet['passphrase'],
            'recipient' => $wallet['address'],
            'vendor_field' => 'Example Message'
        ];

        $sign_transaction = (new Transaction);
        $sign_transaction->setTransaction(new \InfinitySolution\Wallet\Transaction\Transfer);
        $sign_transaction->data($data);
        $sign_transaction->network('Devnet');
        $sign_transaction->server('infinity');
        $tx = $sign_transaction->build();

        print_r($tx);
        $this->assertIsArray($tx);
    }

    public function test_it_returns_signed_transfer_mainnet_transaction()
    {

        $wallet = (new Wallet(new Mainnet()))->generateWallet();

        $data = [
            'fee' => 1001,
            'amount' => 100000000,
            'passphrase' => $wallet['passphrase'],
            'recipient' => $wallet['address'],
            'vendor_field' => 'Example Message'
        ];

        $sign_transaction = (new Transaction);
        $sign_transaction->setTransaction(new \InfinitySolution\Wallet\Transaction\Transfer);
        $sign_transaction->data($data);
        $sign_transaction->network('Mainnet');
        $sign_transaction->server('infinity');
        $tx = $sign_transaction->build();

        print_r($tx);
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
            'vendor_field' => 'Example Message'
        ];

        $sign_transaction = (new Transaction);
        $sign_transaction->setTransaction(new \InfinitySolution\Wallet\Transaction\Transfer);
        $sign_transaction->data($data);
        $sign_transaction->network('Devnet');
        $sign_transaction->server('hedge');
        $tx = $sign_transaction->build();

        print_r($tx);
        $this->assertIsArray($tx);
    }

    public function test_it_returns_signed_transfer_testnet_hedge_transaction()
    {

        $wallet = (new Wallet(new \InfinitySolution\Wallet\Network\Hedge\Testnet))->generateWallet();

        $data = [
            'fee' => 1001,
            'amount' => 100000000,
            'passphrase' => $wallet['passphrase'],
            'recipient' => $wallet['address'],
            'vendor_field' => 'Example Message'
        ];

        $sign_transaction = (new Transaction);
        $sign_transaction->setTransaction(new \InfinitySolution\Wallet\Transaction\Transfer);
        $sign_transaction->data($data);
        $sign_transaction->network('Testnet');
        $sign_transaction->server('hedge');
        $tx = $sign_transaction->build();

        print_r($tx);
        $this->assertIsArray($tx);
    }

    public function test_it_returns_signed_transfer_mainnet_hedge_transaction()
    {

        $wallet = (new Wallet(new \InfinitySolution\Wallet\Network\Hedge\Mainnet))->generateWallet();

        $data = [
            'fee' => 1001,
            'amount' => 100000000,
            'passphrase' => $wallet['passphrase'],
            'recipient' => $wallet['address'],
            'vendor_field' => 'Example Message'
        ];

        $sign_transaction = (new Transaction);
        $sign_transaction->setTransaction(new \InfinitySolution\Wallet\Transaction\Transfer);
        $sign_transaction->data($data);
        $sign_transaction->network('Mainnet');
        $sign_transaction->server('hedge');
        $tx = $sign_transaction->build();

        print_r($tx);
        $this->assertIsArray($tx);
    }

    public function test_it_to_create_webhook()
    {

        $events = [
            [
                'event' => 'transaction.applied',
                'target' => 'https://infinitysolutions.io/api/blockchain-webhooks',
                'conditions' => [
                    [
                        "key" => "recipientId",
                        "condition" => "eq",
                        "value" => "wallet_address"
                    ]
                ]
            ]
        ];

        $event_created = (new Webhook)->create($events);
        $this->assertTrue($event_created);
    }

    public function test_it_to_get_webhooks()
    {
        $event_created = (new Webhook)->getAll();
        $this->assertTrue($event_created);
    }

    public function test_it_get_fees()
    {
        $fees = (new Fee);
        $fees->setPeer('api.infinitysolutions.io');
        $fees->setProtocol('https');
        $fees->setUrlFee('/api/transactions/fees');
        $fees->getFees();

        print_r($fees->getFees());
        $this->assertIsArray($fees->getFees());
    }

    public function test_it_get_peers()
    {
        $peer = (new Peer);
        $peer->setIP('api.infinitysolutions.io');
        $peer->setProtocol('https');
        $peer->setUrlParams('/api/v2/peers');

        print_r($peer->getPeers());
        $this->assertIsArray($peer->getPeers());
    }

}
