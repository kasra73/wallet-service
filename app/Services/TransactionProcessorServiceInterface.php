<?php

declare(strict_types=1);

namespace App\Services;

use App\Internal\Exceptions\LockProviderNotFoundException;
use App\Models\Transaction;
use App\Interfaces\Wallet;

interface TransactionProcessorServiceInterface
{



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
    ): Transaction;

    /**
     * The input means in the system.
     *
     * @throws AmountInvalid
     * @throws LockProviderNotFoundException
     * @throws RecordsNotFoundException
     * @throws TransactionFailedException
     * @throws ExceptionInterface
     */
    public function deposit(
        Wallet $wallet,
        int|string $amount,
        ?array $meta = null,
        bool $confirmed = true
    ): Transaction;


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
    ): Transaction;

    /**
     * Checks if you can withdraw funds.
     */
    public function canWithdraw(Wallet $wallet, int|string $amount, bool $allowZero = false): bool;

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
    ): Transaction;
}
