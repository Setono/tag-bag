<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

final class StyleTag extends ElementTag
{
    /**
     * @return static
     */
    public static function create(string $content, string $name = null): self
    {
        return parent::createWithContent('style', $content, $name ?? 'setono/style-tag');
    }
}
