<?php

declare(strict_types=1);

namespace Setono\TagBag\Storage;

use PHPUnit\Framework\TestCase;

final class InMemoryStorageTest extends TestCase
{
    /**
     * @test
     */
    public function it_stores_and_restores(): void
    {
        $storage = new InMemoryStorage();
        $storage->store('test');

        $this->assertSame('test', $storage->restore());
    }
}
