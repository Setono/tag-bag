<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use Setono\TagBag\Tag\ContentAwareTagInterface;
use Setono\TagBag\Tag\TagInterface;
use Webmozart\Assert\Assert;

class ContentRenderer implements RendererInterface
{
    /**
     * @psalm-assert-if-true ContentAwareTagInterface $tag
     */
    public function supports(TagInterface $tag): bool
    {
        return $tag instanceof ContentAwareTagInterface;
    }

    public function render(TagInterface $tag): string
    {
        Assert::true($this->supports($tag));

        return $tag->getContent();
    }
}
