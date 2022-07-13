<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

trait ContentAwareTrait
{
    protected string $content;

    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return static
     */
    public function withContent(string $content): self
    {
        $obj = clone $this;
        $obj->content = $content;

        return $obj;
    }
}
