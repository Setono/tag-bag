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
     * Will always return an array of sections
     *
     * If the $section is set then the returning array will only hold one section
     *
     * When you call this method, the sections that are returned will be removed from the tag bag
     *
     * @return SectionInterface[]
     */
    public function getTags(string $section = null): array;

    /**
     * Stores the tag bag in the given data store
     */
    public function store(): void;

    /**
     * Restores the tag bag from the given data store
     */
    public function restore(): void;
}
