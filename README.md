# Wallet Library
[![N|Solid](https://infinitysolutions.io/images/logo-light2x.png)](https://infinitysolutions.io/)

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://github.com/InfinitySoftwareLTD/wallet-library)

Wallet library that handles on creating paper wallet that supports Infinity and Hedge coins.

## Features

- Allows to generate paper wallet
- Allows to choose network
- Allows to sign a transaction
- Allows to create webhooks

### Installation

```bash
composer require infinitysoftwareltd/walletlibrary
```

## Usage

#### Networks
- Mainnet
- Testnet
- Devnet

#### Servers
- infinity
- hedge

#### Generate wallet
Add `InfinitySolution\Wallet\Wallet` into your class
```php
use InfinitySolution\Wallet\Wallet;
```
And you can use that to generate the wallet.
```php
$wallet = (new Wallet)->generateWallet();
```
Response:
```json
{
    "passphrase":"video obtain gentle motion furnace cannon section ramp dawn picture kitchen insect",
    "pubkey":"03cb4e966142298ea993cab34cd0983f6c1a49f43fb37d23ab1e5a4e64c606f01e",
    "address":"GT3qtBgpgMMUnUnEQv1snfBxjDq1ghWcLY"
}
```

#### Sign a transaction
To sign a transaction, you need to follow the data structure. It should be an array with fee, amount, passphrase and recipient.
**Example:**
```php
$data = [
    'fee' => 1001,
    'amount' => 100000000,
    'passphrase' => $wallet['passphrase'],
    'recipient' => $wallet['address'],
];
```

You can change the server and the network. We have listed the available servers and networks above.
Add `InfinitySolution\Wallet\Transaction` into your class.
```php
use InfinitySolution\Wallet\Transaction;
```

```php
$wallet = (new Wallet)->generateWallet();

$data = [
    'fee' => 1001,
    'amount' => 100000000,
    'passphrase' => $wallet['passphrase'],
    'recipient' => $wallet['address'],
];

$sign_transaction = (new Transaction);
$sign_transaction->setTransaction(new \InfinitySolution\Wallet\Transaction\Transfer);
$sign_transaction->data($data);
$sign_transaction->network('Mainnet');
$sign_transaction->server('infinity');
return $sign_transaction->build();
```

Response:
```json
{
    "transactions": {
            "transactions":[
                {
                    "type":0,
                    "typeGroup":1,
                    "nonce":"1",
                    "amount":"100000000",
                    "fee":"1001",
                    "version":2,
                    "network":127,
                    "expiration":0,
                    "recipientId":"GTxrmLBmowafJY4i8hrEBjjz7EwCmAWGix",
                    "senderPublicKey":"02fe4823c1af0ef64835ca3b7e4192b5a1f36e550cd1ca793c41cdb73861c9018d",
                    "signature":"3045022100d6acbb49c0a313ee8daa5596abd0bd6740ed6b655efb46e92ffd2f9e2aeeac78022044a99946a0db031c8d33bfe0015f8921d7f785efaae6d6560099dbde2a0c3ab8",
                    "id":"515564c3b26eb0d6a950e13e8825f387162a6cd64358097c00d2877694aa187b"
                }
            ]
    },
    "peer":"http://{your_node_ip_server}:4003/api/transactions"
}
```

#### Webhook
You can create webhook event, delete and update.

#### Create Webhook Event
Follow the data structure to create an event
```php
$events = [
    [
        'event' => 'transaction.applied',
        'target' => 'https://{your_endpoint_post}',
        'conditions' => [
            [
                "key" => "recipientId",
                "condition" => "eq",
                "value" => "wallet_address"
            ]
        ]
    ]
];
```

To create webhook event, invoke this into your class
```php
use InfinitySolution\Wallet\Webhook;
```

And in your controller or PHP class, pass the array of events and it will return `boolean`.
```php
$events = [
    [
        'event' => 'transaction.applied',
        'target' => 'https://{your_endpoint_post}',
        'conditions' => [
            [
                "key" => "recipientId",
                "condition" => "eq",
                "value" => "wallet_address"
            ]
        ]
    ]
];

(new Webhook)->create($events);
```
