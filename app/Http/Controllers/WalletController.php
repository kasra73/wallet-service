<?php

namespace App\Http\Controllers;

use App\Internal\Exceptions\ModelNotFoundException;
use App\Services\WalletServiceInterface;

class WalletController extends Controller
{

    public function __construct(
        private WalletServiceInterface $walletService
    ) { }

    function getBalance(int $user_id) {
        try {
            $wallet = $this->walletService->getByUserId($user_id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'title' => 'Not Found',
                'message' => 'Wallet not found',
            ], 404);
        }
        return response()->json([ 'balance' => $wallet->balance ]);
    }
}
