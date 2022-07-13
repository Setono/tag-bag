<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

interface AttributesAwareInterface
{
    /**
     * @return array<string, string|null>
     */
    public function getAttributes(): array;
}
