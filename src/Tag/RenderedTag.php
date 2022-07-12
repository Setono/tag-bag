<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

/**
 * This class is not intended to be used outside the Setono\TagBag\TagBag class.
 *
 * The reason for having a RenderedTag is that tags implementing the TagInterface can in theory have all sorts of
 * dependencies which in turn makes them harder (if not impossible) to serialize, and the tag bag is serialized upon storing it
 *
 * @internal
 */
final class RenderedTag
{
    private string $name;

    private string $value;

    private string $section;

    private int $priority;

    private bool $unique;

    private string $fingerprint;

    private function __construct(
        string $name,
        string $value,
        string $section,
        int $priority,
        bool $unique,
        string $fingerprint
    ) {
        $this->name = $name;
        $this->value = $value;
        $this->section = $section;
        $this->priority = $priority;
        $this->unique = $unique;
        $this->fingerprint = $fingerprint;
    }

    public static function createFromTag(TagInterface $tag, string $value, string $fingerprint): self
    {
        return new self(
            $tag->getName(),
            $value,
            $tag->getSection(),
            $tag->getPriority(),
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

    public function getSection(): string
    {
        return $this->section;
    }

    public function getPriority(): int
    {
        return $this->priority;
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