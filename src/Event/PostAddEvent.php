<?php

declare(strict_types=1);

namespace Setono\TagBag\Event;

use Setono\TagBag\Tag\Rendered\RenderedTag;
use Setono\TagBag\TagBagInterface;

/**
 * This event is fired when the tag has been added to the tag bag
 */
final class PostAddEvent
{
    /** @var RenderedTag */
    private $tag;

    /** @var TagBagInterface */
    private $tagBag;

    public function __construct(RenderedTag $tag, TagBagInterface $tagBag)
    {
        $this->tag = $tag;
        $this->tagBag = $tagBag;
    }

    public function getTag(): RenderedTag
    {
        return $this->tag;
    }

    public function getTagBag(): TagBagInterface
    {
        return $this->tagBag;
    }
}
