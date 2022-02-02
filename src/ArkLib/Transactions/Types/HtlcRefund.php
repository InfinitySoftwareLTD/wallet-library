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

namespace InfinitySolution\Wallet\ArkLib\Transactions\Types;

use InfinitySolution\Wallet\ArkLib\ByteBuffer\ByteBuffer;

class HtlcRefund extends Transaction
{
    public function serialize(array $options = []): ByteBuffer
    {
        $buffer = ByteBuffer::fromHex($this->data['asset']['refund']['lockTransactionId']);

        return $buffer;
    }

    public function deserialize(ByteBuffer $buffer)
    {
        $lockTransactionId = $buffer->readHex(32 * 2);

        $this->data['asset'] = [
            'refund' => [
                'lockTransactionId' => $lockTransactionId,
            ],
        ];
    }
}
