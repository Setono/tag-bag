<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Setono\TagBag\Tag\StyleTag
 */
final class StyleTagTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates(): void
    {
        $tag = StyleTag::create('content');
        self::assertInstanceOf(TagInterface::class, $tag);
        self::assertInstanceOf(StyleTagInterface::class, $tag);
    }

    /**
     * @test
     */
    public function it_has_default_values(): void
    {
        self::assertSame('setono/style-tag', StyleTag::create('content')->getName());
    }
}
