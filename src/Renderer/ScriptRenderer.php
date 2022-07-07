<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use Setono\TagBag\Tag\ScriptTagInterface;
use Setono\TagBag\Tag\TagInterface;
use Webmozart\Assert\Assert;

final class ScriptRenderer extends ContentRenderer
{
    /**
     * @psalm-assert-if-true ScriptTagInterface $tag
     */
    public function supports(TagInterface $tag): bool
    {
        return parent::supports($tag) && $tag instanceof ScriptTagInterface;
    }

    /**
     * @param TagInterface|ScriptTagInterface $tag
     */
    public function render(TagInterface $tag): string
    {
        Assert::true($this->supports($tag));

        $type = $tag->getType();
        $type = null === $type ? '' : sprintf(' type="%s"', $type);

        return sprintf('<script%s>%s</script>', $type, parent::render($tag));
    }
}
