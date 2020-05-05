<?php

declare(strict_types=1);

namespace Setono\TagBag\Exception;

use InvalidArgumentException;
use function Safe\sprintf;

final class NonExistingTagsException extends InvalidArgumentException
{
    /**
     * @param string[] $nonExistingTags
     */
    public function __construct(array $nonExistingTags)
    {
        parent::__construct(sprintf('The following tags does not exist in the tag bag: %s', implode(', ', $nonExistingTags)));
    }
}
