<?php

declare(strict_types=1);

namespace Setono\TagBag\Exception;

use RuntimeException;

final class SerializationException extends RuntimeException
{
    public static function emptyData(): self
    {
        return new self('The data given was empty');
    }
}
