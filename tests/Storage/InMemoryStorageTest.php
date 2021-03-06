<?php

declare(strict_types=1);

namespace Setono\TagBag\Storage;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Setono\TagBag\Storage\InMemoryStorage
 */
final class InMemoryStorageTest extends TestCase
{
    /**
     * @test
     */
    public function it_stores_and_restores(): void
    {
        $storage = new InMemoryStorage();
        $storage->store('test');

        self::assertSame('test', $storage->restore());
    }

    /**
     * @test
     */
    public function it_removes(): void
    {
        $storage = new InMemoryStorage();
        $storage->store('test');
        $storage->remove();

        self::assertNull($storage->restore());
    }
}
