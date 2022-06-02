<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Internal\Exceptions\LogicExceptionInterface;
use LogicException;

final class BalanceIsEmpty extends LogicException implements LogicExceptionInterface
{
}
