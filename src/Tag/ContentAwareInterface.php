<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

interface ContentAwareInterface
{
    public function getContent(): string;
}
