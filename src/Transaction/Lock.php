<?php namespace InfinitySolution\Wallet\Transaction;

use InfinitySolution\Wallet\ArkLib\Configuration\Network;
use InfinitySolution\Wallet\ArkLib\Identities\PrivateKey;
use InfinitySolution\Wallet\ArkLib\Transactions\Builder\HtlcLockBuilder;
use InfinitySolution\Wallet\ArkLib\Transactions\Builder\TransferBuilder;
use Illuminate\Support\Facades\Validator;
use InfinitySolution\Wallet\TransactionContract;

class Lock implements TransactionContract {

    protected $server, $network, $data;
    protected $peer;
    /**
     * @var string
     */
    protected $protocol = 'http';

    public function blockchain(string $server)
    {
        $this->server = $server;
    }

    public function network(string $network)
    {
        $this->network = $network;
    }

    public function data(array $data)
    {
        $this->data = $data;
    }

    public function peer(string $peer)
    {
        $this->peer = $peer;
    }

    public function protocol(string $protocol)
    {
        $this->protocol = $protocol;
    }

    public function build(): array
    {
        $response = [
            'message' => [],
            'peer' => null,
            'unlockSecretHex' => null
        ];

        $validator = Validator::make($this->data, [
            'nonce' => ['required'],
            'amount' => ['required'],
            'passphrase' => ['required'],
            'recipient' => ['required'],
            'asset.secret_hash' => ['required'],
            'asset.expiration.type' => ['required'],
            'asset.expiration.value' => ['required'],
        ]);

        if ($validator->fails()){
            if ($validator->errors()->hasAny(['network', 'nonce', 'fee', 'amount', 'passphrase', 'recipient', 'asset'])) {
                $message = $validator->errors()->first();
            } else {
                $message = 'There is an error.';
            }

            $response['message'] = $message;
            $response['peer'] = null;
        }

        $password = $this->data['asset']['secret_hash'];

        $unlockSecretHex = hash("sha256", $password);
        $secretHashHex =  hash("sha256", pack("H*", $unlockSecretHex));

        if ($this->server == "infinity"){
            $network = "InfinitySolution\\Wallet\\Network\\Infinity\\".$this->network;
        }else{
            $network = "InfinitySolution\\Wallet\\Network\\Hedge\\".$this->network;
        }

        Network::set(new $network);

        $network = new $network;
        $keys = PrivateKey::fromPassphrase($this->data['passphrase']);
        $publicKey = $keys->getPublicKey()->getHex();

        $client = new \GuzzleHttp\Client();
        $req = $client->get($this->protocol . '://' . $this->peer . '/api/wallets?publicKey=' . $publicKey);
        $nonce = 1;
        if ($data = $req->getBody()->getContents()) {
            $data = json_decode($data);
            if (count($data->data) > 0){
                $nonce = $data->data[0]->nonce + 1;
            }
        }

        // Default Fee
        if (!isset($this->data['fee'])){
            $this->data['fee'] = 300;
        }

        $generated =  HtlcLockBuilder::new()
            ->htlcLockAsset($secretHashHex, $this->data['asset']['expiration']['type'], $this->data['asset']['expiration']['value'])
            ->recipient($this->data['recipient'])
            ->amount($this->data['amount'])
            ->withNonce($nonce)
            ->withFee($this->data['fee']);
        if (!empty($this->data['vendor_field']) && !is_null($this->data['vendor_field'])){
            $generated->vendorField($this->data['vendor_field']);
        }
        $generated->sign($this->data['passphrase']);

        if ($generated){
            $transactions = [
                'transactions' => [$generated->transaction->data]
            ];

            $response['message'] = $transactions;
            $response['peer'] = $this->protocol . '://' . $this->peer . '/api/transactions';
            $response['unlockSecretHex'] = $unlockSecretHex;
        }

        return [
            'transactions' => $response['message'],
            'peer' => $response['peer'],
            'unlockSecretHex' => $response['$unlockSecretHex']
        ];
    }
}
