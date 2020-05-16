<?php

declare(strict_types=1);

namespace Setono\TagBag\Storage;

use PHPUnit\Framework\TestCase;
use RuntimeException;

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

        $this->assertSame('test', $storage->restore());
    }

    /**
     * @test
     */
    public function it_returns_null_if_data_key_is_not_present(): void
    {
        $storage = new SessionStorage();
        $this->assertNull($storage->restore());
    }

    /**
     * @test
     */
    public function it_removes(): void
    {
        $storage = new SessionStorage();
        $storage->store('test');
        $storage->remove();

        $this->assertNull($storage->restore());
    }

    /**
     * @test
     */
    public function it_throws_exception_if_session_is_not_active(): void
    {
        // we include the php_sapi_name function here and this will then be used,
        // instead of the native one, in the SessionStorage class
        require_once 'php_sapi_name.php';

        $this->expectException(RuntimeException::class);

        $storage = new SessionStorage();
        $storage->store('test');
    }
}
