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

use InfinitySolution\Wallet\ArkLib\Identities\PublicKey;
use InfinitySolution\Wallet\ArkLib\Transactions\Types\DelegateRegistration;

/**
 * This is the delegate registration transaction class.
 *
 * @author Brian Faust <brian@ark.io>
 */
class DelegateRegistrationBuilder extends AbstractTransactionBuilder
{
    /**
     * Create a new delegate registration transaction instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->transaction->data['asset'] = ['delegate' => []];
    }

    /**
     * Set the username to assign.
     *
     * @param string $username
     *
     * @return self
     */
    public function username(string $username): self
    {
        $this->transaction->data['asset']['delegate']['username'] = $username;

        return $this;
    }

    /**
     * Sign the transaction using the given passphrase.
     *
     * @param string $passphrase
     *
     * @return self
     */
    public function sign(string $passphrase): AbstractTransactionBuilder
    {
        $publicKey = PublicKey::fromPassphrase($passphrase);

        parent::sign($passphrase);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function getType(): int
    {
        return \InfinitySolution\Wallet\ArkLib\Enums\Types::DELEGATE_REGISTRATION;
    }

    protected function getTypeGroup(): int
    {
        return \InfinitySolution\Wallet\ArkLib\Enums\TypeGroup::CORE;
    }

    protected function getTransactionInstance()
    {
        return new DelegateRegistration();
    }
}
