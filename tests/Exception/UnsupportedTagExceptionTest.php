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

            public function getName(): string
            {
                return 'name';
            }

            public function getDependencies(): array
            {
                return [];
            }

            public function getPriority(): int
            {
                return 0;
            }
        });

        $this->assertRegExp('/The tag [^(]+ \(name\) is not supported/', $exception->getMessage());
    }
}
