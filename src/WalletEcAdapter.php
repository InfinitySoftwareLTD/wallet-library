<?php namespace InfinitySolution\Wallet;

use BitWasp\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\Key\PrivateKeyInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\Key\PublicKeyInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\Signature\CompactSignatureInterface;
use BitWasp\Bitcoin\Math\Math;
use BitWasp\Buffertools\BufferInterface;

class WalletEcAdapter implements EcAdapterInterface{

    public function getMath(): Math
    {
        // TODO: Implement getMath() method.
    }

    public function getGenerator()
    {
        // TODO: Implement getGenerator() method.
    }

    public function getOrder(): \GMP
    {
        // TODO: Implement getOrder() method.
    }

    public function validatePrivateKey(BufferInterface $buffer): bool
    {
        // TODO: Implement validatePrivateKey() method.
    }

    public function validateSignatureElement(\GMP $element, bool $halfOrder = false): bool
    {
        // TODO: Implement validateSignatureElement() method.
    }

    public function getPrivateKey(\GMP $scalar, bool $compressed = false): PrivateKeyInterface
    {
        // TODO: Implement getPrivateKey() method.
    }

    public function recover(BufferInterface $messageHash, CompactSignatureInterface $compactSignature): PublicKeyInterface
    {
        // TODO: Implement recover() method.
    }
}
