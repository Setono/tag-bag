<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

trait AttributesAwareTrait
{
    /** @var array<string, string|null> */
    protected array $attributes = [];

    /**
     * @return array<string, string|null>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param string|int|float|null $val
     *
     * @return static
     */
    public function withAttribute(string $attribute, $val = null): self
    {
        $obj = clone $this;
        $obj->attributes[$attribute] = null === $val ? null : (string) $val;

        return $obj;
    }
}
