<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag\Rendered;

use Countable;

/**
 * @internal
 */
final class RenderedTag implements Countable
{
    /** @var string */
    private $name;

    /** @var string */
    private $value;

    /** @var int */
    private $priority;

    public function __construct(string $name, string $value, int $priority)
    {
        $this->name = $name;
        $this->value = $value;
        $this->priority = $priority;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function count(): int
    {
        return 1;
    }
}
