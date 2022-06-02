<?php

declare(strict_types=1);

namespace App\Services;

use App\Dtos\TransactionDto;
use App\Internal\Exceptions\LockProviderNotFoundException;
use App\Internal\Exceptions\RecordNotFoundException;
use App\Internal\Repositories\TransactionRepositoryInterface;
use App\Internal\Services\MathServiceInterface;
use App\Models\Transaction;
use App\Models\Wallet;

final class TransactionService implements TransactionServiceInterface
{
    public function __construct(
        private PrepareServiceInterface $prepareService,
        private TransactionRepositoryInterface $transactionRepository,
        private WalletServiceInterface $walletService,
        private MathServiceInterface $mathService
    ) {
    }

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
    ): Transaction {
        /** @var TransactionDto $dto */
        $dto = $type === Transaction::TYPE_DEPOSIT
            ? $this->prepareService->deposit($wallet, (string) $amount, $meta, $confirmed)
            : $this->prepareService->withdraw($wallet, (string) $amount, $meta, $confirmed);

        return $this->apply($wallet, $dto);
    }

    /**
     * @param Wallet            $wallet
     * @param TransactionDto    $object
     *
     * @throws LockProviderNotFoundException
     * @throws RecordNotFoundException
     *
     * @return Transaction
     */
    public function apply(Wallet $wallet, TransactionDto $objects): Transaction
    {
        $transaction = $this->makeTransactions($objects);
        $amount = $transaction->amount;
        if ($transaction->confirmed && $this->mathService->compare($amount, 0) !== 0) {
            $this->walletService->updateBalance($wallet, $amount);
        }

        return $transaction;
    }

    /**
     * @param TransactionDto $object
     *
     * @return Transaction
     */
    private function makeTransactions(TransactionDto $object): Transaction
    {
        return $this->transactionRepository->insertOne($object);
    }
}
