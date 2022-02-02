<?php 

namespace InfinitySolution\Wallet;

class Webhook{

    protected $protocol = 'http';
    protected $ip = '63.250.53.87';
    protected $port = '4004';

    /**
     * @param string $protocol
     * @return $this
     */
    public function setProtocol($protocol = 'http'): Webhook
    {
        $this->protocol = $protocol;
        return $this;
    }

    /**
     * @return string
     */
    public function getProtocol(): string
    {
        return $this->protocol;
    }

    /**
     * @param string $ip
     * @return $this
     */
    public function setIP($ip = '63.250.53.87'): Webhook
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return string
     */
    public function getIP(): string
    {
        return $this->ip;
    }

    /**
     * @param string $port
     * @return $this
     */
    public function setPort($port = '4004'): Webhook
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return string
     */
    public function getPort(): string
    {
        return $this->port;
    }

    public function create($data = []): array
    {
        $client = new \GuzzleHttp\Client();
        $req = $client->post($this->getProtocol() . '://' . $this->getIP() . ':'.$this->getPort().'/api/webhooks', [
            'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json'],
            'body'    => json_encode($data)
        ]);
        if ($data = $req->getBody()->getContents()) {
            $data = json_decode($data);

            if (isset($data->data)) {
                return [$data->data];
            }
        }

        return [];
    }

    public function getAll()
    {
        $client = new \GuzzleHttp\Client();
        $req = $client->get($this->getProtocol() . '://' . $this->getIP() . ':'.$this->getPort().'/api/webhooks');
        if ($data = $req->getBody()->getContents()) {
            $data = json_decode($data);

            if (isset($data->data)) {
                return $data->data;
            }
        }

        return [];
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $client = new \GuzzleHttp\Client();
        $req = $client->delete($this->getProtocol() . '://' . $this->getIP() . ':'.$this->getPort().'/api/webhooks/' . $id);
        if ($data = $req->getBody()->getContents()) {
            return true;
        }
        return true;
    }
}
