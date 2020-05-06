<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

final class StyleTag extends ContentTag implements TypeAwareInterface
{
    public function getType(): string
    {
        return TypeAwareInterface::TYPE_STYLE;
    }
}
