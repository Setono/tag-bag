<?php

declare(strict_types=1);

namespace Setono\TagBag\Storage;

/**
 * Most likely you will use this storage for test purposes
 */
final class InMemoryStorage implements StorageInterface
{
    private ?string $store = null;

    public function store(string $data): void
    {
        $this->store = $data;
    }

    public function restore(): ?string
    {
        return $this->store;
    }

    public function remove(): void
    {
        $this->store = null;
    }
}
