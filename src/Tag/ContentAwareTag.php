<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

class ContentAwareTag extends Tag implements ContentAwareInterface
{
    use ContentAwareTrait;

    final private function __construct(string $content, string $name = null)
    {
        parent::__construct($name ?? 'setono/content-aware-tag');

        $this->content = $content;
    }

    /**
     * @return static
     */
    public static function create(string $content, string $name = null): self
    {
        return new static($content, $name);
    }
}
