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

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
