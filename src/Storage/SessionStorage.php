<?php

declare(strict_types=1);

namespace Setono\TagBag\Storage;

use const PHP_SESSION_ACTIVE;
use RuntimeException;

final class SessionStorage implements StorageInterface
{
    public function store(string $data): void
    {
        self::assertSessionIsActive();

        $_SESSION[self::DATA_KEY] = $data;
    }

    public function restore(): ?string
    {
        self::assertSessionIsActive();

        if (!isset($_SESSION[self::DATA_KEY])) {
            return null;
        }

        return $_SESSION[self::DATA_KEY];
    }

    private static function assertSessionIsActive(): void
    {
        if (\PHP_SAPI !== 'cli' && session_status() !== PHP_SESSION_ACTIVE) {
            throw new RuntimeException('Sessions need to be started before calling store/restore');
        }
    }
}
