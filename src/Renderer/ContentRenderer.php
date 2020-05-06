<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use Setono\TagBag\Tag\ContentAwareInterface;
use Setono\TagBag\Tag\TagInterface;

class ContentRenderer implements RendererInterface
{
    public function supports(TagInterface $tag): bool
    {
        return $tag instanceof ContentAwareInterface;
    }

    public function render(TagInterface $tag): string
    {
        return $tag->getContent();
    }
}
