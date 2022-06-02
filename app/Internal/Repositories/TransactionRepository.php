<?php

declare(strict_types=1);

namespace App\Internal\Repositories;

use App\Dtos\TransactionDto;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

final class TransactionRepository implements TransactionRepositoryInterface
{
    public function __construct(
        private Transaction $transaction
    ) {
    }

    public function insertOne(TransactionDto $dto): Transaction
    {
        $instance = $this->transaction->newInstance($dto->extract());
        $instance->saveQuietly();

        return $instance;
    }

    public function getSumTotal(
        \DateTime $from = null,
        \DateTime $to = null,
        $type = null,
        bool $confirmedOnly = true
    ): int|float|string
    {
        $q = $this->makeQuery($from, $to, $type, $confirmedOnly);

        return $q->sum('amount');
    }

    public function getWalletsSumTotal(
        \DateTime $from = null,
        \DateTime $to = null,
        $type = null,
        bool $confirmedOnly = true
    ): Collection
    {
        $q = $this->makeQuery($from, $to, $type, $confirmedOnly);
        $q->groupBy('wallet_id')
            ->select(
                'wallet_id',
                'wallets.user_id',
                DB::raw('SUM(amount)'),
                'wallets.balance'
            )
            ->join('wallets', 'wallets.id', '=', 'transactions.wallet_id');

        return $q->get();
    }

    private function makeQuery(
        \DateTime $from = null,
        \DateTime $to = null,
        $type = null,
        bool $confirmedOnly = true
    )
    {
        $q = $this->transaction->newQuery();
        if($from !== null) {
            $q->where('created_at', '>', $from);
        }
        if($to !== null) {
            $q->where('created_at', '<', $to);
        }
        if($type !== null) {
            $q->where('type', $type);
        }
        if($confirmedOnly !== null) {
            $q->where('confirmed', true);
        }
        return $q;
    }
}
