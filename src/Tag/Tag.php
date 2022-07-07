<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

abstract class Tag implements TagInterface
{
    protected string $name = 'setono_tag_bag_tag';

    protected string $section = self::SECTION_BODY_END;

    protected array $dependencies = [];

    protected int $priority = 0;

    protected bool $unique = true;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): TagInterface
    {
        $this->name = $name;

        return $this;
    }

    public function getSection(): string
    {
        return $this->section;
    }

    public function setSection(string $section): TagInterface
    {
        $this->section = $section;

        return $this;
    }

    public function getDependencies(): array
    {
        return $this->dependencies;
    }

    public function addDependency(string $dependency): TagInterface
    {
        if (!in_array($dependency, $this->dependencies, true)) {
            $this->dependencies[] = $dependency;
        }

        return $this;
    }

    public function removeDependency(string $dependency): TagInterface
    {
        $pos = array_search($dependency, $this->dependencies, true);
        if (false === $pos) {
            return $this;
        }

        array_splice($this->dependencies, (int) $pos, 1);

        return $this;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): TagInterface
    {
        $this->priority = $priority;

        return $this;
    }

    public function isUnique(): bool
    {
        return $this->unique;
    }

    public function setUnique(bool $unique): TagInterface
    {
        $this->unique = $unique;

        return $this;
    }

    public function getFingerprint(): ?string
    {
        return null;
    }
}
