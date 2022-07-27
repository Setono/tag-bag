<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

/**
 * This is a very simple tag that will just output the content you give it
 */
class ContentTag extends Tag implements ContentAwareInterface
{
    use ContentAwareTrait;

    final private function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return static
     */
    public static function create(string $content): self
    {
        return new static($content);
    }
}
