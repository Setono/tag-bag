<?php

declare(strict_types=1);

namespace Setono\TagBag\Storage;

interface StorageInterface
{
    public const DATA_KEY = 'setono_tag_bag';

    /**
     * Stores the given data
     */
    public function store(string $data): void;

    /**
     * Returns the stored data or null if not data is present
     */
    public function restore(): ?string;

    /**
     * Will remove any data stored in the storage
     */
    public function remove(): void;
}
