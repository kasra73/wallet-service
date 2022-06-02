<?php

declare(strict_types=1);

namespace App\Interfaces;

interface Wallet
{
    /**
     * @return int
     */
    public function getUserId(): int;
}
