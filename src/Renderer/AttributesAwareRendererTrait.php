<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use Setono\TagBag\Tag\AttributesAwareInterface;

trait AttributesAwareRendererTrait
{
    public function renderAttributes(AttributesAwareInterface $tag): string
    {
        $attributes = '';

        foreach ($tag->getAttributes() as $attribute => $value) {
            if (null === $value) {
                $attributes .= ' ' . $attribute;
            } else {
                $attributes .= sprintf(' %s="%s"', $attribute, $value);
            }
        }

        return $attributes;
    }
}
