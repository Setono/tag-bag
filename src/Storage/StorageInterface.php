<?php

declare(strict_types=1);

namespace Setono\TagBag\Storage;

use Setono\TagBag\Exception\StorageException;

interface StorageInterface
{
    public const DATA_KEY = 'setono_tag_bag';

    /**
     * Stores the given data
     *
     * @throws StorageException if the storage is unavailable or cannot be stored
     */
    public function store(string $data): void;

    /**
     * Returns the stored data or null if not data is present
     *
     * @throws StorageException if the storage is unavailable or cannot be restored
     */
    public function restore(): ?string;

    /**
     * Will remove any data stored in the storage
     *
     * @throws StorageException if the storage is unavailable or cannot be removed
     */
    public function remove(): void;
}
