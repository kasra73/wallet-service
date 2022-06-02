<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Interfaces\Wallet;

Class WalletDto implements Wallet
{
    public $userId;

    static public function fromRequest($request): WalletDto
    {
        $dto = new WalletDto();
        $dto->userId = $request->input('user_id');
        return $dto;
    }

    /**
     * @return int
     */
    public function getUserId(): int {
        return $this->userId;
    }
}
