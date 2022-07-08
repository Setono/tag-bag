<?php

declare(strict_types=1);

namespace Setono\TagBag\Event;

use Setono\TagBag\Tag\TagInterface;

/**
 * Fired before anything else when trying to add a tag to the tag bag
 */
final class PreTagAddedEvent
{
    public TagInterface $tag;

    public function __construct(TagInterface $tag)
    {
        $this->tag = $tag;
    }
}
