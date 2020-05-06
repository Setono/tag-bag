<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

final class ScriptTag extends ContentTag implements TypeAwareInterface
{
    public function getType(): string
    {
        return TypeAwareInterface::TYPE_SCRIPT;
    }
}
