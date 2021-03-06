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
        $tag = new StyleTag('content');
        self::assertInstanceOf(TagInterface::class, $tag);
        self::assertInstanceOf(StyleTagInterface::class, $tag);
    }

    /**
     * @test
     */
    public function it_has_default_values(): void
    {
        $tag = new StyleTag('content');

        self::assertSame('setono_tag_bag_style_tag', $tag->getName());
    }
}
