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

namespace InfinitySolution\Wallet\ArkLib\Transactions\Builder;

use InfinitySolution\Wallet\ArkLib\Transactions\Types\HtlcLock;

class HtlcLockBuilder extends AbstractTransactionBuilder
{
    public function recipient(string $recipientId): self
    {
        $this->transaction->data['recipientId'] = $recipientId;

        return $this;
    }

    public function amount(string $amount): self
    {
        $this->transaction->data['amount'] = $amount;

        return $this;
    }

    public function htlcLockAsset(string $secretHash, int $expirationType, int $expirationValue): self
    {
        $this->transaction->data['asset'] = [
            'lock' => [
                'secretHash' => $secretHash,
                'expiration' => [
                    'type'  => $expirationType,
                    'value' => $expirationValue,
                ],
            ],
        ];

        return $this;
    }

    public function vendorField(string $vendorField): self
    {
        $this->transaction->data['vendorField'] = $vendorField;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function getType(): int
    {
        return \InfinitySolution\Wallet\ArkLib\Enums\Types::HTLC_LOCK;
    }

    protected function getTypeGroup(): int
    {
        return \InfinitySolution\Wallet\ArkLib\Enums\TypeGroup::CORE;
    }

    protected function getTransactionInstance()
    {
        return new HtlcLock();
    }
}
