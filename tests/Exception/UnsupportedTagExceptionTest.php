<?php

declare(strict_types=1);

namespace Setono\TagBag\Exception;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\Tag;

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
        $exception = new UnsupportedTagException(new class() extends Tag {
            public function getName(): string
            {
                return 'name';
            }
        });

        $this->assertRegExp('/The tag [^(]+ \(name\) is not supported/', $exception->getMessage());
    }
}
