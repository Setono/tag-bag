<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use Setono\TagBag\Tag\ElementTag;
use Setono\TagBag\Tag\TagInterface;
use Webmozart\Assert\Assert;

final class ElementRenderer implements RendererInterface
{
    use AttributesAwareRendererTrait;

    /**
     * @psalm-assert-if-true ElementTag $tag
     */
    public function supports(TagInterface $tag): bool
    {
        return $tag instanceof ElementTag;
    }

    /**
     * @param TagInterface|ElementTag $tag
     */
    public function render(TagInterface $tag): string
    {
        Assert::true($this->supports($tag));

        if ($tag->hasClosingElement()) {
            return sprintf(
                '<%s%s>%s</%s>',
                $tag->getElement(),
                $this->renderAttributes($tag),
                $tag->getContent(),
                $tag->getElement()
            );
        }

        return sprintf(
            '<%s%s>',
            $tag->getElement(),
            $this->renderAttributes($tag),
        );
    }
}
