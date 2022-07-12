<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

final class ScriptTag extends ContentAwareTag implements ScriptTagInterface
{
    /** @var array<string, string|null> */
    private array $attributes = [];

    /**
     * @return static
     */
    public static function create(string $content, string $name = null): self
    {
        return parent::create($content, $name ?? 'setono/script-tag');
    }

    public function getType(): ?string
    {
        return $this->attributes['type'] ?? null;
    }

    /**
     * @return static
     */
    public function withType(string $type): self
    {
        return $this->withAttribute('type', $type);
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
