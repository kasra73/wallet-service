<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\Wallet;
use App\Internal\Exceptions\ExceptionInterface;
use App\Internal\Exceptions\LockProviderNotFoundException;
use App\Internal\Exceptions\TransactionFailedException;
use App\Internal\Services\LockServiceInterface;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Support\Facades\DB;

final class AtomicService implements AtomicServiceInterface
{
    private const PREFIX = 'wallet_locks::';

    public function __construct(
        private LockServiceInterface $lockService,
        private WalletServiceInterface $walletService
    ) {
    }

    /**
     * @throws LockProviderNotFoundException
     * @throws RecordsNotFoundException
     * @throws TransactionFailedException
     * @throws ExceptionInterface
     */
    public function block(Wallet $object, callable $callback): mixed
    {
        return $this->lockService->block(
            $this->key($object),
            fn () => DB::transaction($callback)
        );
    }

    private function key(Wallet $object): string
    {
        $wallet = $this->walletService->cast($object);

        return self::PREFIX.'::'.$wallet::class.'::'.$wallet->getUserId();
    }
}
