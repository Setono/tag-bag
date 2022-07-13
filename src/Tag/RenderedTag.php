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
    /** @readonly */
    public string $value;

    /** @readonly */
    public string $section;

    /** @readonly */
    public int $priority;

    /** @readonly */
    public bool $unique;

    /** @readonly */
    public string $fingerprint;

    private function __construct(
        string $value,
        string $section,
        int $priority,
        bool $unique,
        string $fingerprint
    ) {
        $this->value = $value;
        $this->section = $section;
        $this->priority = $priority;
        $this->unique = $unique;
        $this->fingerprint = $fingerprint;
    }

    public static function createFromTag(TagInterface $tag, string $value, string $fingerprint): self
    {
        return new self(
            $value,
            $tag->getSection(),
            $tag->getPriority(),
            $tag->isUnique(),
            $fingerprint
        );
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
