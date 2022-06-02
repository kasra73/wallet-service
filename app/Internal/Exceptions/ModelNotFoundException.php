<?php

declare(strict_types=1);

namespace App\Internal\Exceptions;

use RuntimeException;

final class ModelNotFoundException extends RuntimeException implements RuntimeExceptionInterface
{
}
