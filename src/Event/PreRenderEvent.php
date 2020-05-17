<?php

declare(strict_types=1);

namespace Setono\TagBag\Event;

use Setono\TagBag\Tag\TagInterface;

/**
 * Fired just before a tag is rendered
 */
final class PreRenderEvent
{
    /** @var TagInterface */
    private $tag;

    public function __construct(TagInterface $tag)
    {
        $this->tag = $tag;
    }

    public function getTag(): TagInterface
    {
        return $this->tag;
    }
}
