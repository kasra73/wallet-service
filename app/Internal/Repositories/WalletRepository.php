<?php

declare(strict_types=1);

namespace App\Internal\Repositories;

use App\Internal\Exceptions\ExceptionInterface;
use App\Internal\Exceptions\ModelNotFoundException;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\ModelNotFoundException as EloquentModelNotFoundException;

final class WalletRepository implements WalletRepositoryInterface
{
    public function __construct(
        private Wallet $wallet
    ) {
    }

    public function create(array $attributes): Wallet
    {
        $instance = $this->wallet->newInstance($attributes);
        $instance->saveQuietly();

        return $instance;
    }

    public function findById(int $id): ?Wallet
    {
        try {
            return $this->getById($id);
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    public function findByUserId(int $userId): ?Wallet
    {
        try {
            return $this->getByUserId($userId);
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Wallet
    {
        return $this->getBy([
            'id' => $id,
        ]);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getByUuid(string $uuid): Wallet
    {
        return $this->getBy([
            'uuid' => $uuid,
        ]);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getByUserId(int $userId): Wallet
    {
        return $this->getBy([
            'user_id' => $userId,
        ]);
    }

    /**
     * @param array<int|string> $userIds
     *
     * @return Wallet[]
     */
    public function findDefaultAll(array $userIds): array
    {
        return $this->wallet->newQuery()
            ->whereIn('user_Id', $userIds)
            ->get()
            ->all()
        ;
    }

    /**
     * @param array<string, int|string> $attributes
     */
    private function getBy(array $attributes): Wallet
    {
        try {
            $wallet = $this->wallet->newQuery()
                ->where($attributes)
                ->firstOrFail();

            return $wallet;
        } catch (EloquentModelNotFoundException $exception) {
            throw new ModelNotFoundException(
                $exception->getMessage(),
                ExceptionInterface::MODEL_NOT_FOUND,
                $exception
            );
        }
    }
}
