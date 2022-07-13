<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use Setono\TagBag\Tag\StyleTag;
use Setono\TagBag\Tag\TagInterface;
use Webmozart\Assert\Assert;

final class StyleRenderer implements RendererInterface
{
    use AttributesAwareRendererTrait;

    /**
     * @psalm-assert-if-true StyleTag $tag
     */
    public function supports(TagInterface $tag): bool
    {
        return $tag instanceof StyleTag;
    }

    /**
     * @param TagInterface|StyleTag $tag
     */
    public function render(TagInterface $tag): string
    {
        Assert::true($this->supports($tag));

        return sprintf('<style%s>%s</style>', $this->renderAttributes($tag), $tag->getContent());
    }
}
