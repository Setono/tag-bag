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
        $this->assertInstanceOf(TagInterface::class, new StyleTag('content'));
    }

    /**
     * @test
     */
    public function it_has_default_values(): void
    {
        $tag = new StyleTag('content');

        $this->assertSame('setono_tag_bag_style_tag', $tag->getName());
        $this->assertSame(TypeAwareInterface::TYPE_STYLE, $tag->getType());
    }
}
