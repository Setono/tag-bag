<?php

declare(strict_types=1);

namespace Setono\TagBag\Exception;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\ContentTag;

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
        $tag = ContentTag::create('content');
        $exception = new UnsupportedTagException($tag);

        self::assertSame(sprintf('The tag %s is not supported', ContentTag::class), $exception->getMessage());
    }
}
