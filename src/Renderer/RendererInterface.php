<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use Setono\TagBag\Tag\TagInterface;

interface RendererInterface
{
    /**
     * Returns true if this renderer supports the given tag
     */
    public function supports(TagInterface $tag): bool;

    /**
     * Renders the given tag as a string
     *
     * It is expected that the supports method has been called before calling this method
     */
    public function render(TagInterface $tag): string;
}
