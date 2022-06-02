<?php

declare(strict_types=1);

namespace App\Services;

use App\Dtos\TransactionDto;
use App\Exceptions\AmountInvalid;
use App\Interfaces\Wallet;

interface PrepareServiceInterface
{
    /**
     * @throws AmountInvalid
     */
    public function deposit(
        Wallet $wallet,
        float|int|string $amount,
        ?array $meta,
        bool $confirmed = true
    ): TransactionDto;

    /**
     * @throws AmountInvalid
     */
    public function withdraw(
        Wallet $wallet,
        float|int|string $amount,
        ?array $meta,
        bool $confirmed = true
    ): TransactionDto;
}
