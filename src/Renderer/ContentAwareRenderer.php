<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use Setono\TagBag\Tag\ContentAwareInterface;
use Setono\TagBag\Tag\TagInterface;
use Webmozart\Assert\Assert;

final class ContentAwareRenderer implements RendererInterface
{
    /**
     * @psalm-assert-if-true ContentAwareInterface $tag
     */
    public function supports(TagInterface $tag): bool
    {
        return $tag instanceof ContentAwareInterface;
    }

    public function render(TagInterface $tag): string
    {
        Assert::true($this->supports($tag));

        return $tag->getContent();
    }
}
