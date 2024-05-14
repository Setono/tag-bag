<?php

declare(strict_types=1);

namespace Setono\TagBag\Event;

use Setono\TagBag\Tag\RenderedTag;
use Setono\TagBag\TagBagInterface;

/**
 * This event is fired when the tag has been added to the tag bag
 */
final class TagAddedEvent
{
    public function __construct(
        public readonly RenderedTag $tag,
        public readonly TagBagInterface $tagBag,
    ) {
    }
}
