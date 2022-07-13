<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use Setono\TagBag\Tag\StyleTagInterface;
use Setono\TagBag\Tag\TagInterface;
use Webmozart\Assert\Assert;

final class StyleRenderer implements RendererInterface
{
    use AttributesAwareRendererTrait;

    /**
     * @psalm-assert-if-true StyleTagInterface $tag
     */
    public function supports(TagInterface $tag): bool
    {
        return $tag instanceof StyleTagInterface;
    }

    /**
     * @param TagInterface|StyleTagInterface $tag
     */
    public function render(TagInterface $tag): string
    {
        Assert::true($this->supports($tag));

        return sprintf('<style%s>%s</style>', $this->renderAttributes($tag), $tag->getContent());
    }
}
