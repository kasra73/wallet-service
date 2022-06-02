<?php

namespace App\Http\Controllers;

use App\Dtos\WalletDto;
use App\Http\Requests\TransactionRequest;
use App\Internal\Exceptions\ModelNotFoundException;
use App\Services\TransactionProcessorServiceInterface;
use App\Services\WalletServiceInterface;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionProcessorServiceInterface $transactionProcessorService
    ) { }

    function addMoney(TransactionRequest $request)
    {
        $wallet = WalletDto::fromRequest($request);
        $amount = $request->input('amount');
        $transaction = $this->transactionProcessorService->processTransaction($wallet, $amount);
        return response()->json([
            'reference_id' => $transaction->uuid
        ]);
    }
}
