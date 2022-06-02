<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\AmountInvalid;
use App\Exceptions\BalanceIsEmpty;
use App\Exceptions\InsufficientFunds;
use App\Models\Wallet;

interface ConsistencyServiceInterface
{
    /**
     * @throws AmountInvalid
     */
    public function checkPositive(float|int|string $amount): void;

    /**
     * @throws BalanceIsEmpty
     * @throws InsufficientFunds
     */
    public function checkPotential(Wallet $object, float|int|string $amount, bool $allowZero = false): void;

    public function canWithdraw(float|int|string $balance, float|int|string $amount, bool $allowZero = false): bool;
}
