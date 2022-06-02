<?php

declare(strict_types=1);

namespace App\Internal\Exceptions;

use UnexpectedValueException;

final class LockProviderNotFoundException extends UnexpectedValueException implements UnexpectedValueExceptionInterface
{
}
