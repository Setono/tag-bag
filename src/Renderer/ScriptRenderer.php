<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use Setono\TagBag\Tag\ScriptTag;
use Setono\TagBag\Tag\TagInterface;
use Webmozart\Assert\Assert;

final class ScriptRenderer implements RendererInterface
{
    use AttributesAwareRendererTrait;

    /**
     * @psalm-assert-if-true ScriptTag $tag
     */
    public function supports(TagInterface $tag): bool
    {
        return $tag instanceof ScriptTag;
    }

    /**
     * @param TagInterface|ScriptTag $tag
     */
    public function render(TagInterface $tag): string
    {
        Assert::true($this->supports($tag));

        return sprintf('<script%s>%s</script>', $this->renderAttributes($tag), $tag->getContent());
    }
}
