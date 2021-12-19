<?php 

namespace InfinitySolution\Wallet;


class Peer{

    protected $ip = 'api.infinitysolutions.io';
    protected $protocol = 'http';
    protected $url_params = '/api/v2/peers';

    public function setIP($ip = 'api.infinitysolutions.io'): Peer
    {
        $this->ip = $ip;
        return $this;
    }

    public function setProtocol($protocol = 'http'): Peer
    {
        $this->protocol = $protocol;
        return $this;
    }

    public function setUrlParams($params = '/api/v2/peers'): Peer
    {
        $this->url_params = $params;
        return $this;
    }

    public function getProtocol(): string
    {
        return $this->protocol;
    }

    public function getIP(): string
    {
        return $this->ip;
    }

    public function getUrlParams(): string
    {
        return $this->url_params;
    }

    public function getPeers(): array
    {
        $client = new \GuzzleHttp\Client();
        $req = $client->get($this->getProtocol() . '://' . $this->getIP() . $this->getUrlParams(), [
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
