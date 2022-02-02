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

use InfinitySolution\Wallet\ArkLib\Transactions\Types\DelegateResignation;

/**
 * This is the delegate resignation transaction class.
 *
 * @author Brian Faust <brian@ark.io>
 */
class DelegateResignationBuilder extends AbstractTransactionBuilder
{
    protected function getType(): int
    {
        return \InfinitySolution\Wallet\ArkLib\Enums\Types::DELEGATE_RESIGNATION;
    }

    protected function getTypeGroup(): int
    {
        return \InfinitySolution\Wallet\ArkLib\Enums\TypeGroup::CORE;
    }

    protected function getTransactionInstance()
    {
        return new DelegateResignation();
    }
}
