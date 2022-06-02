<?php

declare(strict_types=1);

namespace App\Internal\Services;

use App\Internal\Exceptions\LockProviderNotFoundException;

interface LockServiceInterface
{
    /**
     * @throws LockProviderNotFoundException
     */
    public function block(string $key, callable $callback): mixed;
}
