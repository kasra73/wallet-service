<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\Wallet as WalletInterface;
use App\Internal\Exceptions\ModelNotFoundException;
use App\Internal\Repositories\WalletRepositoryInterface;
use App\Internal\Services\MathServiceInterface;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

final class WalletService implements WalletServiceInterface
{
    public function __construct(
        private WalletRepositoryInterface $walletRepository,
        private MathServiceInterface $mathService
    ) { }

    public function cast(WalletInterface $walletInterface, bool $save = true): Wallet
    {
        $wallet = $this->findByUserId($walletInterface->getUserId());
        if ($wallet === null) {
            $wallet = new Wallet([
                'user_id' => $walletInterface->getUserId()
            ]);
        }

        if ($save && !$wallet->exists) {
            DB::transaction(function () use ($wallet) {
                return $wallet->saveQuietly();
            });
        }

        return $wallet;
    }

    public function create(int $userId, array $data = []): Wallet
    {
        return  $this->walletRepository->create(array_merge(
            $data,
            [
                'user_id' => $userId,
            ]
        ));
    }

    public function findByUserId(int $userId): ?Wallet
    {
        return $this->walletRepository->findByUserId($userId);
    }

    public function findById(int $id): ?Wallet
    {
        return $this->walletRepository->findById($id);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getByUserId(int $userId): Wallet
    {
        return $this->walletRepository->getByUserId($userId);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Wallet
    {
        return $this->walletRepository->getById($id);
    }

    public function updateBalance(Wallet $wallet, int|float|string $amount): bool
    {
        $wallet->balance = $this->mathService->add($wallet->balance, $amount);
        $wallet->save();
        return true;
    }
}
