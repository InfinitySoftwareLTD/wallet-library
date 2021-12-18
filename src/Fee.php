<?php 

namespace InfinitySolution\Wallet;


class Fee{

    protected $peer = 'api.infinitysolutions.io';
    protected $protocol = 'http';
    protected $url_fee = '/api/transactions/fees';


    public function setPeer($peer = 'api.infinitysolutions.io')
    {
        $this->peer = $peer;
        return $this;
    }

    public function setProtocol($protocol = 'http')
    {
        $this->protocol = $protocol;
        return $this;
    }

    public function setUrlFee($url_fee = '/api/transactions/fees')
    {
        $this->url_fee = $url_fee;
        return $this;
    }

    public function getProtocol(): string
    {
        return $this->protocol;
    }

    public function getPeer()
    {
        return $this->peer;
    }

    public function getUrlFee()
    {
        return $this->url_fee;
    }

    public function getFees()
    {
        $client = new \GuzzleHttp\Client();
        $req = $client->get($this->getProtocol() . '://' . $this->getPeer() . $this->getUrlFee(), [
            'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json'],
        ]);
        if ($data = $req->getBody()->getContents()) {
            $data = json_decode($data);

            if (isset($data)) {
                return (array) $data;
            }
        }

        return [];
    }

}
