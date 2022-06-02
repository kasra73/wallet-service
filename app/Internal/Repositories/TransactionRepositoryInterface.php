<?php

declare(strict_types=1);

namespace App\Internal\Repositories;

use App\Dtos\TransactionDto;
use App\Models\Transaction;
use Illuminate\Support\Collection;

interface TransactionRepositoryInterface
{
    public function insertOne(TransactionDto $dto): Transaction;

    public function getSumTotal(
        \DateTime $from = null,
        \DateTime $to = null,
        $type = null,
        bool $confirmedOnly = true
    ): int|float|string;

    public function getWalletsSumTotal(
        \DateTime $from = null,
        \DateTime $to = null,
        $type = null,
        bool $confirmedOnly = true
    ): Collection;
}
