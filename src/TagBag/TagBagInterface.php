<?php

declare(strict_types=1);

namespace Setono\TagBag\TagBag;

use Countable;
use Setono\TagBag\Tag\Section\SectionInterface;
use Setono\TagBag\Tag\TagInterface;

interface TagBagInterface extends Countable
{
    public function addTag(TagInterface $tag): void;

    /**
     * NOTICE: All tags are removed from the tag bag after you call this method
     *
     * @return SectionInterface[]
     */
    public function getTags(): array;

    /**
     * Returns null if the section doesn't exist
     *
     * NOTICE: The section is removed from the tag bag after you call this method
     */
    public function getSection(string $section): ?SectionInterface;

    /**
     * Stores the tag bag in the given data store
     */
    public function store(): void;

    /**
     * Restores the tag bag from the given data store
     */
    public function restore(): void;
}
