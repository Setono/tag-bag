<?php

declare(strict_types=1);

namespace Setono\TagBag\Storage;

final class InMemoryStorage implements StorageInterface
{
    /** @var string|null */
    private $store;

    public function store(string $data): void
    {
        $this->store = $data;
    }

    public function restore(): ?string
    {
        return $this->store;
    }
}
