<?php

declare(strict_types=1);

namespace App\Internal\Repositories;

use App\Internal\Exceptions\ModelNotFoundException;
use App\Models\Wallet;

interface WalletRepositoryInterface
{
    public function create(array $attributes): Wallet;

    public function findById(int $id): ?Wallet;

    public function findByUserId(int $userId): ?Wallet;

    /**
     * @param array<int|string> $holderIds
     *
     * @return Wallet[]
     */
    public function findDefaultAll(array $userIds): array;

    /**
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Wallet;

    /**
     * @throws ModelNotFoundException
     */
    public function getByUserId(int $userId): Wallet;
}
