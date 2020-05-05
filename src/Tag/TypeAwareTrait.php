<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

trait TypeAwareTrait
{
    /** @var string */
    protected $type;

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
