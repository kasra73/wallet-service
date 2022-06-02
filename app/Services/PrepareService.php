<?php

declare(strict_types=1);

namespace App\Services;

use App\Dtos\TransactionDto;
use App\Exceptions\AmountInvalid;
use App\Interfaces\Wallet;
use App\Internal\Services\MathServiceInterface;
use App\Internal\Services\UuidFactoryServiceInterface;
use App\Models\Transaction;

final class PrepareService implements PrepareServiceInterface
{
    public function __construct(
        private ConsistencyServiceInterface $consistencyService,
        private WalletServiceInterface $walletService,
        private MathServiceInterface $mathService,
        private UuidFactoryServiceInterface $uuidService
    ) {
    }

    /**
     * @throws AmountInvalid
     */
    public function deposit(
        Wallet $wallet,
        float|int|string $amount,
        ?array $meta,
        bool $confirmed = true
    ): TransactionDto {
        $this->consistencyService->checkPositive($amount);

        return $this->createDto(
            $this->walletService->cast($wallet)
                ->getKey(),
            Transaction::TYPE_DEPOSIT,
            $amount,
            $confirmed,
            $meta
        );
    }

    /**
     * @throws AmountInvalid
     */
    public function withdraw(
        Wallet $wallet,
        float|int|string $amount,
        ?array $meta,
        bool $confirmed = true
    ): TransactionDto {
        $this->consistencyService->checkPositive($amount);

        return $this->createDto(
            $this->walletService->cast($wallet)
                ->getKey(),
            Transaction::TYPE_WITHDRAW,
            $this->mathService->negative($amount),
            $confirmed,
            $meta
        );
    }

    private function createDto(
        int $walletId,
        string $type,
        float|int|string $amount,
        bool $confirmed,
        ?array $meta
    ): TransactionDto {
        return new TransactionDto(
            $this->uuidService->uuid4(),
            $walletId,
            $type,
            $amount,
            $confirmed,
            $meta
        );
    }
}
