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

namespace InfinitySolution\Wallet\ArkLib\Identities;

use InfinitySolution\Wallet\ArkLib\Networks\AbstractNetwork;

/**
 * This is the wif class.
 *
 * @author Brian Faust <brian@ark.io>
 */
class WIF
{
    /**
     * Derive the WIF from the given passphrase.
     *
     * @param string                                             $passphrase
     * @param \InfinitySolution\Wallet\ArkLib\Networks\AbstractNetwork|null $network
     *
     * @return string
     */
    public static function fromPassphrase(string $passphrase, AbstractNetwork $network = null): string
    {
        return PrivateKey::fromPassphrase($passphrase)->toWif($network);
    }
}
