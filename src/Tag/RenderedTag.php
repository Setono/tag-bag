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
final class RenderedTag implements \Stringable
{
    private function __construct(
        public readonly string $value,
        public readonly string $section,
        public readonly int $priority,
        public readonly bool $unique,
        public readonly string $fingerprint,
    ) {
    }

    public static function createFromTag(TagInterface $tag, string $value, string $fingerprint): self
    {
        return new self(
            $value,
            $tag->getSection(),
            $tag->getPriority(),
            $tag->isUnique(),
            $fingerprint,
        );
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
