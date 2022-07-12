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
    /** @readonly */
    public RenderedTag $tag;

    /** @readonly */
    public TagBagInterface $tagBag;

    public function __construct(RenderedTag $tag, TagBagInterface $tagBag)
    {
        $this->tag = $tag;
        $this->tagBag = $tagBag;
    }
}
