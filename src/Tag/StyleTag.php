<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

final class StyleTag extends ContentTag
{
    public function __construct(string $key, string $content)
    {
        parent::__construct($key, $content, TypeAwareInterface::TYPE_STYLE);
    }
}
