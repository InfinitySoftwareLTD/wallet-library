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

namespace InfinitySolution\Wallet\ArkLib\Binary\Buffer\Reader\Concerns;

use InfinitySolution\Wallet\ArkLib\Binary\Hex\Reader;

trait Hex
{
    /**
     * Read N characters of bytes in hex with high nibble.
     *
     * @param int $length
     *
     * @return \InfinitySolution\Wallet\ArkLib\Binary\Buffer\Reader\Buffer
     */
    public function readHex(int $length)
    {
        $value = Reader::high($this->bytes, 0, $length * 2);

        $this->skip($length);

        return $value;
    }

    /**
     * Read N characters of a raw hex string and turn them into bytes.
     *
     * @param int $length
     *
     * @return \InfinitySolution\Wallet\ArkLib\Binary\Buffer\Reader\Buffer
     */
    public function readHexBytes(int $length)
    {
        return hex2bin($this->readHexRaw($length));
    }

    /**
     * Read N characters of a raw hex string.
     *
     * @param int $length
     *
     * @return \InfinitySolution\Wallet\ArkLib\Binary\Buffer\Reader\Buffer
     */
    public function readHexRaw(int $length)
    {
        return substr($this->hex, $this->offset, $length);
    }
}
