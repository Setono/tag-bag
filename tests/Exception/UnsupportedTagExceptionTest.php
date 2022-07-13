<?php

declare(strict_types=1);

namespace Setono\TagBag\Exception;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\ContentAwareTag;

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
        $tag = ContentAwareTag::create('content');
        $exception = new UnsupportedTagException($tag);

        self::assertSame(sprintf('The tag %s is not supported', ContentAwareTag::class), $exception->getMessage());
    }
}
