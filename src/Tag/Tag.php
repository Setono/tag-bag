<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

class Tag implements TagInterface
{
    /** @var string */
    protected $key;

    /** @var string|null */
    protected $section;

    /** @var array */
    protected $dependents = [];

    /** @var int */
    protected $priority = 0;

    /** @var bool */
    protected $replace = true;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getSection(): ?string
    {
        return $this->section;
    }

    public function setSection(?string $section): self
    {
        $this->section = $section;

        return $this;
    }

    public function getDependents(): array
    {
        return $this->dependents;
    }

    public function addDependent(string $dependent): self
    {
        if (!in_array($dependent, $this->dependents, true)) {
            $this->dependents[] = $dependent;
        }

        return $this;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function willReplace(): bool
    {
        return $this->replace;
    }

    public function setReplace(bool $replace): self
    {
        $this->replace = $replace;

        return $this;
    }
}
