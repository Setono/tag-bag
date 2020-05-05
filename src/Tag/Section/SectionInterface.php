<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag\Section;

use Countable;
use Setono\TagBag\Tag\Rendered\RenderedTag;
use Traversable;

interface SectionInterface extends Countable, Traversable
{
    public function __toString(): string;

    public function addTag(RenderedTag $renderedTag): void;

    /**
     * Returns true if this section has a tag key that equals $key
     */
    public function hasTag(string $key): bool;
}
