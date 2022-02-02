<?php namespace InfinitySolution\Wallet\Transaction;

use InfinitySolution\Wallet\ArkLib\Configuration\Network;
use InfinitySolution\Wallet\ArkLib\Identities\PrivateKey;
use InfinitySolution\Wallet\ArkLib\Transactions\Builder\HtlcClaimBuilder;
use InfinitySolution\Wallet\ArkLib\Transactions\Builder\HtlcLockBuilder;
use InfinitySolution\Wallet\ArkLib\Transactions\Builder\TransferBuilder;
use Illuminate\Support\Facades\Validator;
use InfinitySolution\Wallet\TransactionContract;

class Claim implements TransactionContract {

    protected $server, $network, $data;

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

    public function build(): array
    {
        $response = [
            'message' => [],
            'peer' => null,
        ];

        $validator = Validator::make($this->data, [
            'passphrase' => ['required'],
            'asset.claim.lockTransactionId' => ['required'],
            'asset.claim.unlockSecret' => ['required'],
        ]);

        if ($validator->fails()){
            if ($validator->errors()->hasAny(['network', 'nonce', 'passphrase', 'asset'])) {
                $message = $validator->errors()->first();
            } else {
                $message = 'There is an error.';
            }

            $response['message'] = $message;
            $response['peer'] = null;
        }

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
        $req = $client->get($network->peer() . '/wallets?publicKey=' . $publicKey);
        $nonce = 1;
        if ($data = $req->getBody()->getContents()) {
            $data = json_decode($data);
            if (count($data->data) > 0){
                $nonce = $data->data[0]->nonce + 1;
            }
        }

        $generated =  HtlcClaimBuilder::new();
        $generated->htlcClaimAsset($this->data['asset']['claim']['lockTransactionId'], $this->data['asset']['claim']['unlockSecret']);
        $generated->withNonce($nonce);
        $generated->sign($this->data['passphrase']);

        if (!empty($this->data['vendor_field']) && !is_null($this->data['vendor_field'])){
            $generated->vendorField($this->data['vendor_field']);
        }
        $generated->sign($this->data['passphrase']);

        if ($generated){
            $transactions = [
                'transactions' => [$generated->transaction->data]
            ];

            $response['message'] = $transactions;
            $response['peer'] = $network->peer() . '/transactions';
        }

        return [
            'transactions' => $response['message'],
            'peer' => $response['peer'],
        ];
    }
}
