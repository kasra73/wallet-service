<?php

declare(strict_types=1);

namespace App\Services;

use App\Dtos\TransactionDto;
use App\Internal\Exceptions\LockProviderNotFoundException;
use App\Internal\Exceptions\RecordNotFoundException;
use App\Models\Transaction;
use App\Models\Wallet;

interface TransactionServiceInterface
{
    /**
     * @throws LockProviderNotFoundException
     * @throws RecordNotFoundException
     */
    public function makeOne(
        Wallet $wallet,
        string $type,
        float|int|string $amount,
        ?array $meta,
        bool $confirmed = true
    ): Transaction;

    /**
     * @param Wallet                  $wallet
     * @param TransactionDto $object
     *
     * @throws LockProviderNotFoundException
     * @throws RecordNotFoundException
     *
     * @return non-empty-array<string, Transaction>
     */
    public function apply(Wallet $wallet, TransactionDto $objects): Transaction;
}
