<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

class ContentTag extends Tag implements ContentAwareInterface
{
    use ContentAwareTrait;

    public function __construct(string $key, string $content)
    {
        parent::__construct($key);

        $this->content = $content;
    }
}
