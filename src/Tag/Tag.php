<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

abstract class Tag implements TagInterface
{
    protected string $section = self::SECTION_BODY_END;

    protected int $priority = 0;

    protected bool $unique = true;

    protected ?string $fingerprint = null;

    public function getSection(): string
    {
        return $this->section;
    }

    public function withSection(string $section): static
    {
        return $this->with('section', $section);
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function withPriority(int $priority): static
    {
        return $this->with('priority', $priority);
    }

    public function isUnique(): bool
    {
        return $this->unique;
    }

    public function unique(): static
    {
        return $this->withUnique(true);
    }

    public function notUnique(): static
    {
        return $this->withUnique(false);
    }

    public function withUnique(bool $unique): static
    {
        return $this->with('unique', $unique);
    }

    public function getFingerprint(): ?string
    {
        return $this->fingerprint;
    }

    public function withFingerprint(string $fingerprint): static
    {
        return $this->with('fingerprint', $fingerprint);
    }

    /**
     * This is a helper method for immutable withers
     */
    protected function with(string $property, mixed $val): static
    {
        $obj = clone $this;
        $obj->{$property} = $val; // @phpstan-ignore property.dynamicName

        return $obj;
    }
}
