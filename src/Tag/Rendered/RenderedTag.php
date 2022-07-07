<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag\Rendered;

use Setono\TagBag\Tag\TagInterface;

/**
 * This class is not intended to be used outside the TagBag class.
 *
 * The reason for having a RenderedTag is that tags implementing the TagInterface can in theory have all sorts of
 * dependencies which in turn makes it harder to serialize, and the tag bag is serialized upon storing it
 */
final class RenderedTag
{
    private string $name;

    private string $value;

    private int $priority;

    private string $section;

    /** @var string[] */
    private array $dependencies;

    private bool $unique;

    private string $fingerprint;

    private function __construct(
        string $name,
        string $value,
        int $priority,
        string $section,
        array $dependencies,
        bool $unique,
        string $fingerprint
    ) {
        $this->name = $name;
        $this->value = $value;
        $this->priority = $priority;
        $this->section = $section;
        $this->dependencies = $dependencies;
        $this->unique = $unique;
        $this->fingerprint = $fingerprint;
    }

    public static function createFromTag(TagInterface $tag, string $value, string $fingerprint): self
    {
        return new self(
            $tag->getName(),
            $value,
            $tag->getPriority(),
            $tag->getSection(),
            $tag->getDependencies(),
            $tag->isUnique(),
            $fingerprint
        );
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

    public function getDependencies(): array
    {
        return $this->dependencies;
    }

    public function isUnique(): bool
    {
        return $this->unique;
    }

    public function getFingerprint(): string
    {
        return $this->fingerprint;
    }
}
