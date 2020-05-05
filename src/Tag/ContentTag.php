<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

class ContentTag extends Tag implements ContentAwareInterface, TypeAwareInterface
{
    use ContentAwareTrait;
    use TypeAwareTrait;

    public function __construct(string $key, string $content, string $type)
    {
        parent::__construct($key);

        $this->content = $content;
        $this->type = $type;
    }
}
