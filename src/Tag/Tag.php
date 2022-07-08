<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

abstract class Tag implements TagInterface
{
    private string $name;

    protected string $section = self::SECTION_BODY_END;

    protected int $priority = 0;

    protected bool $unique = true;

    protected ?string $fingerprint = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return static
     */
    public function withName(string $name): self
    {
        $obj = clone $this;
        $obj->name = $name;

        return $obj;
    }

    public function getSection(): string
    {
        return $this->section;
    }

    /**
     * @return static
     */
    public function withSection(string $section): self
    {
        $obj = clone $this;
        $obj->section = $section;

        return $obj;
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
        $obj = clone $this;
        $obj->priority = $priority;

        return $obj;
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
        $obj = clone $this;
        $obj->unique = true;

        return $obj;
    }

    /**
     * @return static
     */
    public function notUnique(): self
    {
        $obj = clone $this;
        $obj->unique = false;

        return $obj;
    }

    /**
     * @return static
     */
    public function withUnique(bool $unique): self
    {
        $obj = clone $this;
        $obj->unique = $unique;

        return $obj;
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
        $obj = clone $this;
        $obj->fingerprint = $fingerprint;

        return $obj;
    }
}
