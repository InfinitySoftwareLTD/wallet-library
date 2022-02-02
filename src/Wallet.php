<?php 

namespace InfinitySolution\Wallet;

use BitWasp\Bitcoin\Exceptions\RandomBytesFailure;
use InfinitySolution\Wallet\Network\Infinity\Mainnet;
use InfinitySolution\Wallet\ArkLib\Identities\Address;
use InfinitySolution\Wallet\ArkLib\Identities\PrivateKey;
use BitWasp\Bitcoin\Mnemonic\Bip39\Bip39Mnemonic;
use BitWasp\Bitcoin\Mnemonic\Bip39\Wordlist\EnglishWordList;

class Wallet{

    protected $entropySize;
    protected $network;

    /**
     * Wallet constructor.
     * @param int $entropySize
     * @param Mainnet $network
     */
    public function __construct($network = null, $entropySize = 128)
    {
        $this->entropySize = $entropySize;
        $this->network = is_null($network) ? new Mainnet : $network;
    }

    /**
     * @return array
     * @throws RandomBytesFailure
     */
    public function generateWallet(): array
    {
        return $this->createWallet($this->generatePassphrase());
    }

    /**
     * @return string
     * @throws RandomBytesFailure
     */
    public function generatePassphrase(): string
    {
        return (new Bip39Mnemonic(new WalletEcAdapter, new EnglishWordList))->create($this->entropySize);
    }

    /**
     * @param $passphrase
     * @return array
     */
    public function createWallet($passphrase): array
    {
        $privateKey = PrivateKey::fromPassphrase($passphrase);
        return [
            'passphrase' => $passphrase,
            'pubkey' => $privateKey->getPublicKey()->getHex(),
            'address' => Address::fromPrivateKey($privateKey, $this->network),
        ];
    }

    /**
     * @param $address
     * @return bool
     */
    public function validateAddress($address): bool
    {
        return Address::validate($address, $this->network);
    }
}
