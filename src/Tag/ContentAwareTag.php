<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

class ContentAwareTag extends Tag implements ContentAwareTagInterface
{
    protected string $content;

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

    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return static
     */
    public function withContent(string $content): self
    {
        return $this->with('content', $content);
    }
}
