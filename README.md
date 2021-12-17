# Wallet Library
[![N|Solid](https://infinitysolutions.io/images/logo-light2x.png)](https://infinitysolutions.io/)

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://github.com/InfinitySoftwareLTD/wallet-library)

Wallet library that handles on creating paper wallet that supports Infinity and Hedge token.

## Features

- Allows to generate paper wallet
- Allows to choose network
- Allows to sign a transaction
- Allows to send a transaction
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
Generating wallet have different networks which are `Mainnet`, `Devnet` and `Testnet`.
Each networks has their own wallet prefix.

```php
Testnet = t
Devnet = x
Mainnet = G
```

Add `InfinitySolution\Wallet\Wallet` into your class
```php
use InfinitySolution\Wallet\Wallet;
```
##### Testnet
To create wallet for this network. Add this into your class.
```php
use InfinitySolution\Wallet\Network\Infinity\Testnet;
```

Invoke the `Testnet` into wallet constructor.
```php
$wallet = (new Wallet(new Testnet))->generateWallet();
```
Response:
```json
{
    "passphrase":"lizard apart sing melt replace verify keep chair endorse truly crawl basket",
    "pubkey":"025286998d31a898bd60cb16be09c87a85fbfd3cd824a441a714d7643903a47ca1",
    "address":"tTEp99x1DMnEDhSgVy4ruhDMMkXP67MbsF"
}
```

##### Devnet
To create wallet for this network. Add this into your class.
```php
use InfinitySolution\Wallet\Network\Infinity\Devnet;
```

Invoke the `Devnet` into wallet constructor.
```php
$wallet = (new Wallet(new Devnet))->generateWallet();
```
Response:
```json
{
    "passphrase":"series elephant swamp attend uniform opinion average input project outer tennis feel",
    "pubkey":"038a7002316832cbee49a27fc2d44d0ebadb385597c9dd5e97ae8e11abedf4150b",
    "address":"xEUisYP6fhD685FerFsJRB2UNzFxEQJ79m"
}
```

##### Mainnet
To create wallet for this network. Add this into your class.
```php
use InfinitySolution\Wallet\Network\Infinity\Mainnet;
```

Invoke the `Mainnet` into wallet constructor.
```php
$wallet = (new Wallet(new Mainnet))->generateWallet();
```
Response:
```json
{
    "passphrase":"lunar chuckle paddle diamond clip swallow use bright hat jeans spawn virus",
    "pubkey":"033713279146a679a9430f80174e017f90de22b1c2a3c51a83c22fd3f21aade01b",
    "address":"GRLbCpaWi1DePju8m6G4Xkn6i59ddq4Luw"
}
```


#### Sign a transaction
To sign a transaction, you need to follow the data structure. It should be an array with fee, amount, passphrase and recipient.
**Example:**
```php
$data = [
    'fee' => {FEE},
    'amount' => {AMOUNT IN DECIMAL},
    'passphrase' => {PASSPHRASE},
    'recipient' => {WALLET_ADDRESS},
];
```

You can change the server and the network. We have listed the available servers and networks above.
Add `InfinitySolution\Wallet\Transaction` into your class.
```php
use InfinitySolution\Wallet\Transaction;
```

##### Testnet

For the `Testnet` you need to set the network and server once you instantiate the `Transaction` class.
```php
$wallet = (new Wallet(new Testnet))->generateWallet();

$data = [
    'fee' => 1001,
    'amount' => 100000000,
    'passphrase' => $wallet['passphrase'],
    'recipient' => $wallet['address'],
];

$sign_transaction = (new Transaction);
$sign_transaction->setTransaction(new \InfinitySolution\Wallet\Transaction\Transfer);
$sign_transaction->data($data);
$sign_transaction->network('Testnet');
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
                    "recipientId":"tAvoigCkJe4pxkngs6ChdRKojjCoE1f6s2",
                    "senderPublicKey":"03688ab87c4b4a9e7f74e9ae0f67ffa05108924595d8ff539b5fa7635be8a68c9b",
                    "signature":"3045022100ea2d326409ea88da4a7eaa47717391c712b4c4e534e79005ce8a51f00a45eebe02204a9de894d6437ad851b06116dfda7769b0ebdd3f22bc586b7a2ca953906832bb",
                    "id":"515564c3b26eb0d6a950e13e8825f387162a6cd64358097c00d2877694aa187b"
                }
            ]
    },
    "peer":"https://{your_node_ip_server}:4003/api/transactions"
}
```


##### Devnet

For the `Devnet` you need to set the network and server once you instantiate the `Transaction` class.
```php
$wallet = (new Wallet(new Devnet))->generateWallet();

$data = [
    'fee' => 1001,
    'amount' => 100000000,
    'passphrase' => $wallet['passphrase'],
    'recipient' => $wallet['address'],
];

$sign_transaction = (new Transaction);
$sign_transaction->setTransaction(new \InfinitySolution\Wallet\Transaction\Transfer);
$sign_transaction->data($data);
$sign_transaction->network('Devnet');
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
                    "network":137,
                    "expiration":0,
                    "recipientId":"xNjK5NaJ43YEofwNDf5wQncsRHit5qBjik",
                    "senderPublicKey":"035aa61875fc9dae2abac08b03b831692fe269a7dfb25d7e437ce9215ef5ffde44",
                    "signature":"3045022100f1122f5b91b4e09f6abd1f3503ab113d75efd6ecd5d9d43c7bfbae6db74f3fea02201101657ad9349129288ec65be9442e9d999fb6b4afd47038cbe2636d2440d971",
                    "id":"2f21e2527e4b9f4ab8366766f72e2c08a480cfa221bdd4eb8b7c8bdb4e8277c2"
                }
            ]
    },
    "peer":"https://{your_node_ip_server}:4003/api/transactions"
}
```

##### Mainnet

For the `Mainnet` you need to set the network and server once you instantiate the `Transaction` class.
```php
$wallet = (new Wallet(new Mainnet))->generateWallet();

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
                    "network":38,
                    "expiration":0,
                    "recipientId":"GaH5knapB7hHmVN7JQNswnW1uuSnAoxRGh",
                    "senderPublicKey":"035e65bbf63d1d17f5e1765482402ce0ec67e7e1e250e5b09886ae0b59a1fdf3a6",
                    "signature":"30450221009c2951bf48dcafba06456491f85fe22813100237b4ff61a77b96290a6a8638ad022079efe66b39201de85dd11a3e5cd688767b0c98f0e889ef2ee8e8eccd9e1d6997",
                    "id":"94761b12525e3b8b769f2b629fd1b3ac693e0e7856043f7080f9b7574fbb7a4c"
                }
            ]
    },
    "peer":"https://{your_node_ip_server}:4003/api/transactions"
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