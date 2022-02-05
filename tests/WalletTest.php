<?php namespace InfinitySolution\Wallet\Tests;

use Illuminate\Support\Facades\Log;
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

        $this->assertArrayHasKey('passphrase', $wallet, "Array doesn't contains 'passphrase' as key");
        $this->assertArrayHasKey('pubkey', $wallet, "Array doesn't contains 'pubkey' as key");
        $this->assertArrayHasKey('address', $wallet, "Array doesn't contains 'address' as key");
    }

    public function test_it_returns_created_devnet_wallet()
    {
        $wallet = (new Wallet(new Devnet))->generateWallet();

        $this->assertArrayHasKey('passphrase', $wallet, "Array doesn't contains 'passphrase' as key");
        $this->assertArrayHasKey('pubkey', $wallet, "Array doesn't contains 'pubkey' as key");
        $this->assertArrayHasKey('address', $wallet, "Array doesn't contains 'address' as key");
    }

    public function test_it_returns_created_mainnet_wallet()
    {
        $wallet = (new Wallet(new Mainnet))->generateWallet();

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
        $sign_transaction->blockchain('infinity');
        $tx = $sign_transaction->build();

        $this->assertArrayHasKey('transactions', $tx);
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
        $sign_transaction->blockchain('infinity');
        $tx = $sign_transaction->build();

        $this->assertArrayHasKey('transactions', $tx);
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
        $sign_transaction->blockchain('infinity');
        $sign_transaction->peer('{PEER}:{PORT}');
        $tx = $sign_transaction->build();

        print_r($tx);

        $this->assertArrayHasKey('transactions', $tx);
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
        $sign_transaction->blockchain('hedge');
        $tx = $sign_transaction->build();

        $this->assertArrayHasKey('transactions', $tx);
    }

    public function test_it_returns_signed_transfer_testnet_hedge_transaction()
    {

        $wallet = (new Wallet(new \InfinitySolution\Wallet\Network\Hedge\Testnet))->generateWallet();

        $data = [
            'amount' => 100000000,
            'passphrase' => $wallet['passphrase'],
            'recipient' => $wallet['address'],
            'vendor_field' => 'Example Message'
        ];

        $sign_transaction = (new Transaction);
        $sign_transaction->setTransaction(new \InfinitySolution\Wallet\Transaction\Transfer);
        $sign_transaction->data($data);
        $sign_transaction->network('Testnet');
        $sign_transaction->blockchain('hedge');
        $tx = $sign_transaction->build();

        $this->assertArrayHasKey('transactions', $tx);
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
        $sign_transaction->blockchain('hedge');
        $tx = $sign_transaction->build();

        $this->assertArrayHasKey('transactions', $tx);
    }

    public function test_it_sends_the_signed_tx_to_node()
    {

        $wallet = (new Wallet(new \InfinitySolution\Wallet\Network\Hedge\Mainnet))->generateWallet();

        $data = [
            'fee' => 90,
            'amount' => 100000,
            'passphrase' => '{SENDER_PASSPHRASE}',
            'recipient' => '{RECIPIENT_WALLET_ADDRESS}',
            'vendor_field' => 'TEST MESSAGE'
        ];

        $sign_transaction = (new Transaction);
        $sign_transaction->setTransaction(new \InfinitySolution\Wallet\Transaction\Transfer);
        $sign_transaction->data($data);
        $sign_transaction->network('Mainnet');
        $sign_transaction->blockchain('infinity');
        $sign_transaction->peer('{IP_PEER}:{PORT}');
        $tx = $sign_transaction->build();

        $peer = $tx['peer'];

        $client = new \GuzzleHttp\Client();
        $req = $client->post($peer, ['json'=> $tx['transactions']]);

        $data = $req->getBody()->getContents();
        if ($data) {
            $data = json_decode($data);
            // This will return an object of ['accept' => ['transaction_id']]
        }

        $this->assertTrue(true);

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
        $this->assertTrue(is_array($event_created));
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

        $this->assertArrayHasKey('data', $fees->getFees());
    }

    public function test_it_get_peers()
    {
        $peer = (new Peer);
        $peer->setIP('api.infinitysolutions.io');
        $peer->setProtocol('https');
        $peer->setUrlParams('/api/v2/peers');

        print_r($peer->getPeers());
        $this->assertArrayHasKey('data', $peer->getPeers());
    }

}
