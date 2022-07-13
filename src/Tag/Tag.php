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

    /**
     * @return static
     */
    public function withSection(string $section): self
    {
        return $this->with('section', $section);
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @return static
     */
    public function withPriority(int $priority): self
    {
        return $this->with('priority', $priority);
    }

    public function isUnique(): bool
    {
        return $this->unique;
    }

    /**
     * @return static
     */
    public function unique(): self
    {
        return $this->withUnique(true);
    }

    /**
     * @return static
     */
    public function notUnique(): self
    {
        return $this->withUnique(false);
    }

    /**
     * @return static
     */
    public function withUnique(bool $unique): self
    {
        return $this->with('unique', $unique);
    }

    public function getFingerprint(): ?string
    {
        return $this->fingerprint;
    }

    /**
     * @return static
     */
    public function withFingerprint(string $fingerprint): self
    {
        return $this->with('fingerprint', $fingerprint);
    }

    /**
     * @param mixed $val
     *
     * @return static
     */
    protected function with(string $property, $val): self
    {
        $obj = clone $this;
        $obj->{$property} = $val;

        return $obj;
    }
}
