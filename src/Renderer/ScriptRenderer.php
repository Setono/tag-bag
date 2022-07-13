<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use Setono\TagBag\Tag\ScriptTagInterface;
use Setono\TagBag\Tag\TagInterface;
use Webmozart\Assert\Assert;

final class ScriptRenderer implements RendererInterface
{
    /**
     * @psalm-assert-if-true ScriptTagInterface $tag
     */
    public function supports(TagInterface $tag): bool
    {
        return $tag instanceof ScriptTagInterface;
    }

    /**
     * @param TagInterface|ScriptTagInterface $tag
     */
    public function render(TagInterface $tag): string
    {
        Assert::true($this->supports($tag));

        $attributes = '';

        if ([] !== $tag->getAttributes()) {
            foreach ($tag->getAttributes() as $attribute => $value) {
                if (null === $value) {
                    $attributes .= ' ' . $attribute;
                } else {
                    $attributes .= sprintf(' %s="%s"', $attribute, $value);
                }
            }
        }

        return sprintf('<script%s>%s</script>', $attributes, $tag->getContent());
    }
}
