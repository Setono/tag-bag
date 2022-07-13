<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

final class StyleTag extends ContentAwareTag implements AttributesAwareInterface
{
    use AttributesAwareTrait;

    /**
     * @return static
     */
    public static function create(string $content, string $name = null): self
    {
        return parent::create($content, $name ?? 'setono/style-tag');
    }
}
