<?php

declare(strict_types=1);

namespace App\Internal\Services;

interface UuidFactoryServiceInterface
{
    public function uuid4(): string;
}
