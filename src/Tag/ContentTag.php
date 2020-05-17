<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

class ContentTag extends Tag implements ContentAwareInterface
{
    use ContentAwareTrait;

    public function __construct(string $content)
    {
        $this->setName('setono_tag_bag_content_tag');

        $this->content = $content;
    }
}
