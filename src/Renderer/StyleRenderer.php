<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use Setono\TagBag\Tag\ContentAwareInterface;
use Setono\TagBag\Tag\TagInterface;
use Setono\TagBag\Tag\TypeAwareInterface;
use Webmozart\Assert\Assert;

final class StyleRenderer extends Renderer
{
    public function supports(TagInterface $tag): bool
    {
        return $tag instanceof TypeAwareInterface && $tag->getType() === TypeAwareInterface::TYPE_STYLE && $tag instanceof ContentAwareInterface;
    }

    public function render(TagInterface $tag): string
    {
        Assert::isInstanceOf($tag, ContentAwareInterface::class);

        return $this->renderWithWrapper($tag->getContent(), '<style>');
    }
}
