<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag\Rendered;

/**
 * @internal
 */
final class RenderedTag implements RenderedTagInterface
{
    /** @var string */
    private $key;

    /** @var string */
    private $value;

    /** @var int */
    private $priority;

    /** @var bool */
    private $replace;

    public function __construct(string $key, string $value, int $priority, bool $replace)
    {
        $this->key = $key;
        $this->value = $value;
        $this->priority = $priority;
        $this->replace = $replace;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function willReplace(): bool
    {
        return $this->replace;
    }
}
