<?php namespace InfinitySolution\Wallet\Transaction;

use InfinitySolution\Wallet\ArkLib\Configuration\Network;
use InfinitySolution\Wallet\ArkLib\Identities\PrivateKey;
use InfinitySolution\Wallet\ArkLib\Transactions\Builder\TransferBuilder;
use Illuminate\Support\Facades\Validator;
use InfinitySolution\Wallet\TransactionContract;

class Transfer implements TransactionContract {

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
            'peer' => null
        ];

        $validator = Validator::make($this->data, [
            'amount' => ['required'],
            'passphrase' => ['required'],
            'recipient' => ['required'],
        ]);

        if ($validator->fails()){
            if ($validator->errors()->hasAny(['network', 'nonce', 'fee', 'amount', 'passphrase', 'recipient'])) {
                $message = $validator->errors()->first();
            } else {
                $message = 'There is an error.';
            }

            return $response = [
                'message' => $message,
                'peer' => null
            ];
        }

        // Default Fee
        if (!isset($this->data['fee'])){
            $this->data['fee'] = 90;
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

        $generated =  TransferBuilder::new()
            ->recipient($this->data['recipient'])
            ->amount($this->data['amount'])
            ->withFee($this->data['fee'])
            ->withNonce($nonce);
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
            'peer' => $response['peer']
        ];
    }
}
