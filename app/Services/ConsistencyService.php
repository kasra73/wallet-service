<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\AmountInvalid;
use App\Exceptions\BalanceIsEmpty;
use App\Exceptions\InsufficientFunds;
use App\Internal\Exceptions\ExceptionInterface;
use App\Internal\Services\MathServiceInterface;
use App\Models\Wallet;

final class ConsistencyService implements ConsistencyServiceInterface
{
    public function __construct(
        private MathServiceInterface $mathService,
        private WalletServiceInterface $walletService
    ) {
    }

    /**
     * @throws AmountInvalid
     */
    public function checkPositive(float|int|string $amount): void
    {
        if ($this->mathService->compare($amount, 0) === -1) {
            throw new AmountInvalid(
                'The price should be positive',
                ExceptionInterface::AMOUNT_INVALID
            );
        }
    }

    /**
     * @throws BalanceIsEmpty
     * @throws InsufficientFunds
     */
    public function checkPotential(Wallet $object, float|int|string $amount, bool $allowZero = false): void
    {
        $wallet = $this->walletService->cast($object, false);

        if (($this->mathService->compare($amount, 0) !== 0) && ($this->mathService->compare($wallet->balance, 0) === 0)) {
            throw new BalanceIsEmpty(
                'Wallet is empty',
                ExceptionInterface::BALANCE_IS_EMPTY
            );
        }

        if (!$this->canWithdraw($wallet->balance, $amount, $allowZero)) {
            throw new InsufficientFunds(
                'Insufficient funds',
                ExceptionInterface::INSUFFICIENT_FUNDS
            );
        }
    }

    public function canWithdraw(float|int|string $balance, float|int|string $amount, bool $allowZero = false): bool
    {
        /**
         * Allow buying for free with a negative balance.
         */
        if ($allowZero && !$this->mathService->compare($amount, 0)) {
            return true;
        }

        return $this->mathService->compare($balance, $amount) >= 0;
    }
}
