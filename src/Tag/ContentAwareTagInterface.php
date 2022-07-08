<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

interface ContentAwareTagInterface extends TagInterface
{
    public function getContent(): string;
}
