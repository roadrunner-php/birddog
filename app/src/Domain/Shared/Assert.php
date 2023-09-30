<?php

declare(strict_types=1);

namespace App\Domain\Shared;

use App\Domain\Shared\Exception\InvalidArgumentException;

final class Assert extends \Webmozart\Assert\Assert
{
    /**
     * @psalm-external-mutation-free
     */
    protected static function reportInvalidArgument($message)
    {
        throw new InvalidArgumentException($message);
    }
}
