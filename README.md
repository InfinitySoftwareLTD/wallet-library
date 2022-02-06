# Wallet Library
[![N|Solid](https://infinitysolutions.io/images/logo-light2x.png)](https://infinitysolutions.io/)

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://github.com/InfinitySoftwareLTD/wallet-library)

Wallet library that handles on creating paper wallet that supports Infinity and Hedge coins.

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

### Usage

#### Networks
- Mainnet
- Testnet
- Devnet

#### Coins Blockchains
- infinity
- hedge

## Generate wallet
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
### Testnet
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

### Devnet
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

### Mainnet
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


## Generate QRcode for the costumers

Your exchange is probably generating QRcode wallet address for your costumers.
The format expected by mobile App Infinity to reconize the network and the wallet is {network}:{address}

#### Example 

##### for Blockchain Infinity 
    infi:GWHtg6SufVqKx539msjMoZZqa89g9Z4tg8
##### for Blockchain Hedge    
    edge:GWHtg6SufVqKx539msjMoZZqa89g9Z4tg8
    
    

## Sign a transaction
To sign a transaction, you need to follow the data structure. It should be an array with fee, amount, passphrase and recipient.
**Example:**
```php
$data = [
    'fee' => {FEE},
    'amount' => {AMOUNT IN DECIMAL},
    'passphrase' => {SENDER_PASSPHRASE},
    'recipient' => {WALLET_ADDRESS},
    'vendor_field' => {YOUR MESSAGE OR NOTE | THIS IS OPTIONAL}
];
```

You can change the server and the network. We have listed the available servers and networks above.
Add `InfinitySolution\Wallet\Transaction` into your class.
```php
use InfinitySolution\Wallet\Transaction;
```

### Testnet

For the `Testnet` you need to set the network and server once you instantiate the `Transaction` class.
```php
$wallet = (new Wallet(new Testnet))->generateWallet();

$data = [
    'amount' => 100000000,
    'passphrase' => $wallet['passphrase'],
    'recipient' => '{RECIPIENT ADDRESS}',
    'vendor_field' => 'Example Message'
];

$sign_transaction = (new Transaction);
$sign_transaction->setTransaction(new \InfinitySolution\Wallet\Transaction\Transfer);
$sign_transaction->data($data);
$sign_transaction->network('Testnet');
$sign_transaction->blockchain('infinity');
$sign_transaction->peer('{IP_PEER}:{PORT}');
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
                    "fee":"90",
                    "version":2,
                    "network":127,
                    "expiration":0,
                    "recipientId":"tAvoigCkJe4pxkngs6ChdRKojjCoE1f6s2",
                    "vendorField":"Example Message",
                    "senderPublicKey":"03688ab87c4b4a9e7f74e9ae0f67ffa05108924595d8ff539b5fa7635be8a68c9b",
                    "signature":"3045022100ea2d326409ea88da4a7eaa47717391c712b4c4e534e79005ce8a51f00a45eebe02204a9de894d6437ad851b06116dfda7769b0ebdd3f22bc586b7a2ca953906832bb",
                    "id":"515564c3b26eb0d6a950e13e8825f387162a6cd64358097c00d2877694aa187b"
                }
            ]
    },
    "peer":"https://{your_node_ip_server}:4003/api/transactions"
}
```


### Devnet

For the `Devnet` you need to set the network and server once you instantiate the `Transaction` class.
```php
$wallet = (new Wallet(new Devnet))->generateWallet();

$data = [
    'amount' => 100000000,
    'passphrase' => $wallet['passphrase'],
    'recipient' => '{RECIPIENT ADDRESS}',
    'vendor_field' => 'Example Message'
];

$sign_transaction = (new Transaction);
$sign_transaction->setTransaction(new \InfinitySolution\Wallet\Transaction\Transfer);
$sign_transaction->data($data);
$sign_transaction->network('Devnet');
$sign_transaction->blockchain('infinity');
$sign_transaction->peer('{IP_PEER}:{PORT}');
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
                    "fee":"90",
                    "version":2,
                    "network":137,
                    "expiration":0,
                    "recipientId":"xNjK5NaJ43YEofwNDf5wQncsRHit5qBjik",
                    "vendorField":"Example Message",
                    "senderPublicKey":"035aa61875fc9dae2abac08b03b831692fe269a7dfb25d7e437ce9215ef5ffde44",
                    "signature":"3045022100f1122f5b91b4e09f6abd1f3503ab113d75efd6ecd5d9d43c7bfbae6db74f3fea02201101657ad9349129288ec65be9442e9d999fb6b4afd47038cbe2636d2440d971",
                    "id":"2f21e2527e4b9f4ab8366766f72e2c08a480cfa221bdd4eb8b7c8bdb4e8277c2"
                }
            ]
    },
    "peer":"https://{your_node_ip_server}:4003/api/transactions"
}
```

### Mainnet

For the `Mainnet` you need to set the network and server once you instantiate the `Transaction` class.
```php
$wallet = (new Wallet(new Mainnet))->generateWallet();

$data = [
    'amount' => 100000000,
    'passphrase' => $wallet['passphrase'],
    'recipient' => '{RECIPIENT ADDRESS}',
    'vendor_field' => 'Example Message'
];

$sign_transaction = (new Transaction);
$sign_transaction->setTransaction(new \InfinitySolution\Wallet\Transaction\Transfer);
$sign_transaction->data($data);
$sign_transaction->network('Mainnet');
$sign_transaction->blockchain('infinity');
$sign_transaction->peer('{IP_PEER}:{PORT}');
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
                    "fee":"90",
                    "version":2,
                    "network":38,
                    "expiration":0,
                    "recipientId":"GaH5knapB7hHmVN7JQNswnW1uuSnAoxRGh",
                    "vendorField":"Example Message",
                    "senderPublicKey":"035e65bbf63d1d17f5e1765482402ce0ec67e7e1e250e5b09886ae0b59a1fdf3a6",
                    "signature":"30450221009c2951bf48dcafba06456491f85fe22813100237b4ff61a77b96290a6a8638ad022079efe66b39201de85dd11a3e5cd688767b0c98f0e889ef2ee8e8eccd9e1d6997",
                    "id":"94761b12525e3b8b769f2b629fd1b3ac693e0e7856043f7080f9b7574fbb7a4c"
                }
            ]
    },
    "peer":"https://{your_node_ip_server}:4003/api/transactions"
}
```

## Send the transaction into blockchain
Send transaction into node with custom peer.
```php
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


```


## Webhook
You can create webhook event, delete and update. You can setup your own protocol, IP address and port. Just follow these code once you instantiate the `Webhook` event class.
##### [First setup the webhook to your node](https://doc.infinitysolutions.io/install-webhook/)
```php
$webhook = new Webhook;

$webhook->setProtocol({YOUR PROTOCOL});
$webhook->setIP({YOUR NODE SERVER});
$webhook->setPort({YOUR PORT});
```
**Example**
```php
$webhook = new Webhook;

$webhook->setProtocol('http');
$webhook->setIP('63.250.53.87');
$webhook->setPort('4004');
```


### Create Webhook Event
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
        'event' => 'transaction.applied',
        'target' => 'https://{your_endpoint_post}',
        'conditions' => [
            [
                "key" => "recipientId",
                "condition" => "eq",
                "value" => "wallet_address"
            ]
        ]
];

(new Webhook)->create($events);
```

### Create multiple conditions of webhook

You can make multiple conditions per webhook event by adding additional conditions in the `array`
```php
$events = [
    'event' => 'transaction.applied',
    'target' => 'https://{your_endpoint_post}',
    'conditions' => [
        [
            "key" => "senderPublicKey",
            "condition" => "eq",
            "value" => "{YOUR SENDER PUBLIC KEY}"
        ],
        [
            "key" => "recipientId",
            "condition" => "eq",
            "value" => "{YOUR WALLET ADDRESS}"
        ]
    ]
];

(new Webhook)->create($events);
```

### Get all webhooks
You can get the list of your webhooks created.
```php
return (new Webhook)->getAll();
```
If you have your own node server you can set that to get your latest weebhooks by doing this.
 ```php
$webhook = new Webhook;
$webhook->setProtocol({YOUR PROTOCOL});
$webhook->setIP({YOUR NODE IP});
$webhook->setPort({YOUR NODE PORT});
return $webhook->getAll();
 ```

**Example**
 ```php
$webhook = new Webhook;
$webhook->setProtocol('http');
$webhook->setIP('63.250.53.87');
$webhook->setPort('4004');
return $webhook->getAll();
 ```

### Delete Webhook
You can delete your own webhook by using this code. If the deletion was successful it should return a `boolean`.
```php
$webhook = new Webhook;
$webhook->delete({WEBHOOK-ID});
```

**Example**
```php
$webhook = new Webhook;
$webhook->delete('bc983be2-1b8a-4415-a9c3-09fda240928d');
```

And if you have your own node, you can add your own protocol, IP and port by using this.
```php
$webhook = new Webhook;
$webhook->setProtocol({YOUR PROTOCOL});
$webhook->setIP({YOUR NODE IP});
$webhook->setPort({YOUR NODE PORT});
$webhook->delete({WEBHOOK-ID});
```

**Example**
```php
$webhook = new Webhook;
$webhook->setProtocol('http');
$webhook->setIP('63.250.53.87');
$webhook->setPort('4004');
$webhook->delete('bc983be2-1b8a-4415-a9c3-09fda240928d');
```

## Fees
You can get your own fees from your node. Add this into your php file or class.
```php
use InfinitySolution\Wallet\Fee;
```

You can also set your own protocol, peer, and URL fee by adding this command once you instantiate the `new Fee();` class.

```php
$fees = (new Fee);
$fees->setPeer({URL_PEER});
$fees->setProtocol({PROTOCOL});
$fees->setUrlFee({YOUR_URL_FEE});
return $fees->getFees();
```

**Example**
```php
$fees = (new Fee);
$fees->setPeer('api.infinitysolutions.io');
$fees->setProtocol('https');
$fees->setUrlFee('/api/transactions/fees');
return $fees->getFees();
```

**Response**
```json
{
  "data": {
    "1": {
      "transfer": "90",
      "secondSignature": "100000",
      "delegateRegistration": "1000000",
      "vote": "100",
      "multiSignature": "100000",
      "ipfs": "500000",
      "multiPayment": "100000",
      "delegateResignation": "100",
      "htlcLock": "300",
      "htlcClaim": "0",
      "htlcRefund": "0"
    }
  }
}
```

## Peers
You can get your list of peers by invoking this into your class or php file.
```php
use InfinitySolution\Wallet\Peer;
```

You can set your own node by using this:
```php
$peer = (new Peer);
$peer->setIP({YOUR NODE IP});
$peer->setProtocol({YOUR PROTOCOL});
$peer->setUrlParams({YOUR URL PARAMS});
return $peer->getPeers();
```

**Example**
```php
$peer = (new Peer);
$peer->setIP('api.infinitysolutions.io');
$peer->setProtocol('https');
$peer->setUrlParams('/api/v2/peers');
return $peer->getPeers();
```

**Response**
```json
{
  "meta": {
    "count": 23,
    "pageCount": 1,
    "totalCount": 23,
    "next": null,
    "previous": null,
    "self": "/peers?page=1&limit=100",
    "first": "/peers?page=1&limit=100",
    "last": "/peers?page=1&limit=100"
  },
  "data": [
    {
      "ip": "159.65.199.136",
      "port": 4002,
      "ports": {
        "@arkecosystem/core-webhooks": -1,
        "@arkecosystem/core-exchange-json-rpc": -1,
        "@arkecosystem/core-api": 4003,
        "@arkecosystem/core-wallet-api": 4040
      },
      "version": "2.6.38",
      "height": 6678599,
      "latency": 3
    },
    {
      "ip": "89.233.107.30",
      "port": 4002,
      "ports": {
        "@arkecosystem/core-webhooks": -1,
        "@arkecosystem/core-exchange-json-rpc": -1,
        "@arkecosystem/core-wallet-api": 4040,
        "@arkecosystem/core-api": 4003
      },
      "version": "2.6.38",
      "height": 6678598,
      "latency": 4
    }
  ]
}
```
