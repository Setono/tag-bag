<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag\Rendered;

use Countable;
use Setono\TagBag\Tag\TagInterface;

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

    /** @var string */
    private $section;

    private function __construct(string $name, string $value, int $priority, string $section)
    {
        $this->name = $name;
        $this->value = $value;
        $this->priority = $priority;
        $this->section = $section;
    }

    public static function createFromTag(TagInterface $tag, string $value): self
    {
        return new self($tag->getName(), $value, $tag->getPriority(), $tag->getSection());
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

    public function getSection(): string
    {
        return $this->section;
    }

    public function count(): int
    {
        return 1;
    }
}
