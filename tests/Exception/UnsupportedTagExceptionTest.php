<?php

declare(strict_types=1);

namespace Setono\TagBag\Exception;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\TagInterface;

/**
 * @covers \Setono\TagBag\Exception\UnsupportedTagException
 */
final class UnsupportedTagExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function it_instantiates(): void
    {
        $exception = new UnsupportedTagException(new class() implements TagInterface {
            public function getSection(): ?string
            {
                return null;
            }

            public function getKey(): string
            {
                return 'key';
            }

            public function getDependents(): array
            {
                return [];
            }

            public function getPriority(): int
            {
                return 0;
            }

            public function willReplace(): bool
            {
                return true;
            }
        });

        $this->assertRegExp('/The tag [^(]+ \(key\) is not supported/', $exception->getMessage());
    }
}
