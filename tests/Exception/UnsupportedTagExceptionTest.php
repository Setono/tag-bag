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
        $tag = ContentAwareTag::create('content')->withName('name');
        $exception = new UnsupportedTagException($tag);

        self::assertMatchesRegularExpression('/The tag [^(]+ \(name\) is not supported/', $exception->getMessage());
    }
}
