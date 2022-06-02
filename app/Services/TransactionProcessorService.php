<?php

declare(strict_types=1);

namespace App\Services;

use App\Internal\Exceptions\LockProviderNotFoundException;
use App\Models\Transaction;
use App\Interfaces\Wallet;
use App\Internal\Services\MathServiceInterface;

final class TransactionProcessorService implements TransactionProcessorServiceInterface
{
    public function __construct(
        private AtomicServiceInterface $atomicService,
        private ConsistencyServiceInterface $consistencyService,
        private MathServiceInterface $mathService,
        private TransactionServiceInterface $transactionService,
        private WalletServiceInterface $walletService
    ) {
    }

    /**
     * The input means in the system.
     *
     * @throws AmountInvalid
     * @throws LockProviderNotFoundException
     * @throws RecordsNotFoundException
     * @throws TransactionFailedException
     * @throws ExceptionInterface
     */
    public function processTransaction(
        Wallet $wallet,
        int|string $amount,
        ?array $meta = null,
        bool $confirmed = true
    ): Transaction
    {
        $wallet = $this->walletService->cast($wallet);
        if ($this->mathService->compare($amount, 0) >= 0) {
            return $this->deposit($wallet, $amount, $meta, $confirmed);
        } else {
            return $this->withdraw($wallet, $this->mathService->negative($amount), $meta, $confirmed);
        }
    }

    /**
     * The input means in the system.
     *
     * @throws AmountInvalid
     * @throws LockProviderNotFoundException
     * @throws RecordsNotFoundException
     * @throws TransactionFailedException
     * @throws ExceptionInterface
     */
    public function deposit(Wallet $wallet, int|string $amount, ?array $meta = null, bool $confirmed = true): Transaction
    {
        return $this->atomicService->block(
            $wallet,
            fn () => $this->transactionService
                ->makeOne($wallet, Transaction::TYPE_DEPOSIT, $amount, $meta, $confirmed)
        );
    }

    /**
     * Withdrawals from the system.
     *
     * @throws AmountInvalid
     * @throws BalanceIsEmpty
     * @throws InsufficientFunds
     * @throws LockProviderNotFoundException
     * @throws RecordsNotFoundException
     * @throws TransactionFailedException
     * @throws ExceptionInterface
     */
    public function withdraw(
        Wallet $wallet,
        int|string $amount,
        ?array $meta = null,
        bool $confirmed = true
    ): Transaction
    {
        /** @var Wallet */
        $this->consistencyService->checkPotential($wallet, $amount);

        return $this->forceWithdraw($wallet, $amount, $meta, $confirmed);
    }

    /**
     * Checks if you can withdraw funds.
     */
    public function canWithdraw(Wallet $object, int|string $amount, bool $allowZero = false): bool
    {
        $wallet = $this->walletService->cast($object);

        return $this->consistencyService->canWithdraw($wallet->balance, $amount, $allowZero);
    }

    /**
     * Forced to withdraw funds from system.
     *
     * @throws AmountInvalid
     * @throws LockProviderNotFoundException
     * @throws RecordsNotFoundException
     * @throws TransactionFailedException
     * @throws ExceptionInterface
     */
    public function forceWithdraw(
        Wallet $wallet,
        int|string $amount,
        array|null $meta = null,
        bool $confirmed = true
    ): Transaction {
        return $this->atomicService->block(
            $wallet,
            fn () => $this->transactionService
                ->makeOne($wallet, Transaction::TYPE_WITHDRAW, $amount, $meta, $confirmed)
        );
    }
}
