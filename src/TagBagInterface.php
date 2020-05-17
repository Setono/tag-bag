<?php

declare(strict_types=1);

namespace Setono\TagBag;

use Countable;
use Setono\TagBag\Tag\Rendered\RenderedTag;
use Setono\TagBag\Tag\TagInterface;

interface TagBagInterface extends Countable
{
    public function addTag(TagInterface $tag): self;

    public function getAll(): array;

    /**
     * Returns null if the section doesn't exist
     *
     * @return RenderedTag[]
     */
    public function getSection(string $section): ?array;

    /**
     * If the tag is empty, it renders an empty string, i.e. ''
     *
     * NOTICE: All tags are removed from the tag bag when this method is called
     */
    public function renderAll(): string;

    /**
     * If the section doesn't exist, this method will render an empty string, i.e. ''
     *
     * NOTICE: The section is removed from the tag bag when this method is called
     */
    public function renderSection(string $section): string;

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
