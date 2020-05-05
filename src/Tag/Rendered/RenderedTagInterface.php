<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag\Rendered;

use Countable;

/**
 * @internal
 */
interface RenderedTagInterface extends Countable
{
    public function __toString(): string;

    public function getPriority(): int;
}
