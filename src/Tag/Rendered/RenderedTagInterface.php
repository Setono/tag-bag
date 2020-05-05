<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag\Rendered;

/**
 * @internal
 */
interface RenderedTagInterface
{
    public function __toString(): string;

    public function getPriority(): int;
}
