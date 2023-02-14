<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

use InvalidArgumentException;

trait AttributesAwareTrait
{
    /** @var array<string, string|null> */
    protected array $attributes = [];

    public function hasAttribute(string $attribute): bool
    {
        return array_key_exists($attribute, $this->attributes);
    }

    public function getAttribute(string $attribute): ?string
    {
        if (!$this->hasAttribute($attribute)) {
            throw new InvalidArgumentException(sprintf('The attribute "%s" does not exist', $attribute));
        }

        return $this->attributes[$attribute];
    }

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
