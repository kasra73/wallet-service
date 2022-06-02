<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\Wallet as WalletInterface;
use App\Internal\Exceptions\ModelNotFoundException;
use App\Models\Wallet;

interface WalletServiceInterface
{
    public function cast(WalletInterface $walletInterface, bool $save = true): Wallet;

    public function create(int $userId, array $data = []): Wallet;

    public function findByUserId(int $userId): ?Wallet;

    public function findById(int $id): ?Wallet;

    /**
     * @throws ModelNotFoundException
     */
    public function getByUserId(int $userId): Wallet;

    /**
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Wallet;

    public function updateBalance(Wallet $wallet, int|float|string $amount): bool;
}
