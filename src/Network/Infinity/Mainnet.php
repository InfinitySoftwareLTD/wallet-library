<?php

declare(strict_types=1);

/*
 * This file is part of Ark PHP Crypto.
 *
 * (c) Ark Ecosystem <info@ark.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace InfinitySolution\Wallet\Network\Infinity;

use InfinitySolution\Wallet\ArkLib\Networks\AbstractNetwork;

/**
 * This is the mainnet network class.
 *
 * @author Brian Faust <brian@ark.io>
 */
class Mainnet extends AbstractNetwork
{
    /**
     * {@inheritdoc}
     *
     * @see Network::$base58PrefixMap
     */
    protected $base58PrefixMap = [
        self::BASE58_ADDRESS_P2PKH => '26',
        self::BASE58_ADDRESS_P2SH  => '00',
        self::BASE58_WIF           => 'aa',
    ];

    /**
     * {@inheritdoc}
     *
     * @see Network::$bip32PrefixMap
     */
    protected $bip32PrefixMap = [
        self::BIP32_PREFIX_XPUB => '46090600',
        self::BIP32_PREFIX_XPRV => '46089520',
    ];

    /**
     * {@inheritdoc}
     */
    public function pubKeyHash(): int
    {
        return 38;
    }

    /**
     * {@inheritdoc}
     */
    public function epoch(): string
    {
        return '2017-03-21T13:00:00.000Z';
    }

    /**
     * @return string
     */
    public function peer(): string
    {
//        return 'https://60.250.54.39:4003/api';
        return 'https://api.infinitysolutions.io/api';
    }
}
