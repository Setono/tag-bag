<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

use InvalidArgumentException;
use JsonSerializable;
use Stringable;

/**
 * This class is not intended to be used outside the Setono\TagBag\TagBag class.
 *
 * The reason for having a RenderedTag is that tags implementing the TagInterface can in theory have all sorts of
 * dependencies which in turn makes them harder (if not impossible) to serialize, and the tag bag is serialized upon storing it
 *
 * @internal
 */
final class RenderedTag implements Stringable, JsonSerializable
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

    public static function createFromArray(array $data): self
    {
        if (!isset($data['value'], $data['section'], $data['priority'], $data['unique'], $data['fingerprint'])) {
            throw new InvalidArgumentException('The data array must contain the keys "value", "section", "priority", "unique", and "fingerprint"');
        }

        if (!is_string($data['value']) || !is_string($data['section']) || !is_int($data['priority']) || !is_bool($data['unique']) || !is_string($data['fingerprint'])) {
            throw new InvalidArgumentException('The data array must have the correct types for the keys "value" (string), "section" (string), "priority" (int), "unique" (bool), and "fingerprint" (string)');
        }

        return new self(
            $data['value'],
            $data['section'],
            $data['priority'],
            $data['unique'],
            $data['fingerprint'],
        );
    }

    public function __toString(): string
    {
        return $this->value;
    }

    /** @return array{value: string, section: string, priority: int, unique: bool, fingerprint: string} */
    public function jsonSerialize(): array
    {
        return [
            'value' => $this->value,
            'section' => $this->section,
            'priority' => $this->priority,
            'unique' => $this->unique,
            'fingerprint' => $this->fingerprint,
        ];
    }
}
