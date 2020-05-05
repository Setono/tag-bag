<?php

declare(strict_types=1);

namespace Setono\TagBag\Exception;

use InvalidArgumentException;
use function Safe\sprintf;
use Setono\TagBag\Tag\TagInterface;

final class UnsupportedTagException extends InvalidArgumentException
{
    public function __construct(TagInterface $tag)
    {
        parent::__construct(sprintf('The tag %s is not supported', get_class($tag)));
    }
}
