<?php

declare(strict_types=1);

namespace Setono\TagBag\Storage;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Setono\TagBag\Storage\SessionStorage
 * @runTestsInSeparateProcesses
 */
final class SessionStorageTest extends TestCase
{
    /**
     * @test
     */
    public function it_stores_and_restores(): void
    {
        $storage = new SessionStorage();
        $storage->store('test');

        self::assertSame('test', $storage->restore());
    }

    /**
     * @test
     */
    public function it_returns_null_if_data_key_is_not_present(): void
    {
        $storage = new SessionStorage();
        self::assertNull($storage->restore());
    }

    /**
     * @test
     */
    public function it_removes(): void
    {
        $storage = new SessionStorage();
        $storage->store('test');
        $storage->remove();

        self::assertNull($storage->restore());
    }
}
