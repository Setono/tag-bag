<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

abstract class Tag implements TagInterface
{
    /** @var string */
    protected $name = 'setono_tag_bag_tag';

    /** @var string */
    protected $section = self::SECTION_BODY_END;

    /** @var array */
    protected $dependencies = [];

    /** @var int */
    protected $priority = 0;

    /** @var bool */
    protected $unique = false;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSection(): string
    {
        return $this->section;
    }

    public function setSection(string $section): self
    {
        $this->section = $section;

        return $this;
    }

    public function getDependencies(): array
    {
        return $this->dependencies;
    }

    public function addDependency(string $dependency): self
    {
        if (!in_array($dependency, $this->dependencies, true)) {
            $this->dependencies[] = $dependency;
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

    public function isUnique(): bool
    {
        return $this->unique;
    }

    public function setUnique(bool $unique): self
    {
        $this->unique = $unique;

        return $this;
    }
}
