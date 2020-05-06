<?php

declare(strict_types=1);

namespace Setono\TagBag;

use Countable;
use Setono\TagBag\Tag\Section\SectionInterface;
use Setono\TagBag\Tag\TagInterface;

interface TagBagInterface extends Countable
{
    public function addTag(TagInterface $tag): self;

    /**
     * NOTICE: All tags are removed from the tag bag after you call this method
     *
     * @return SectionInterface[]
     */
    public function getAll(): array;

    /**
     * Returns null if the section doesn't exist
     *
     * NOTICE: The section is removed from the tag bag after you call this method
     */
    public function getSection(string $section): ?SectionInterface;

    /**
     * Stores the tag bag in the given storage
     */
    public function store(): void;

    /**
     * Restores the tag bag from the given storage
     *
     * NOTICE: This also means that if the storage is empty, it will effectively reset the tag bag
     */
    public function restore(): void;
}
