<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

final class StyleTag extends ContentTag implements StyleTagInterface
{
    public function __construct(string $content)
    {
        parent::__construct($content);

        $this->setName('setono_tag_bag_style_tag');
    }
}
