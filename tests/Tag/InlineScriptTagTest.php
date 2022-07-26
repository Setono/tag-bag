<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

use PHPUnit\Framework\TestCase;

final class InlineScriptTagTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates(): void
    {
        $tag = InlineScriptTag::create('content');
        self::assertInstanceOf(TagInterface::class, $tag);
        self::assertInstanceOf(ContentAwareInterface::class, $tag);
        self::assertInstanceOf(AttributesAwareInterface::class, $tag);
    }

    /**
     * @test
     */
    public function it_has_default_values(): void
    {
        $tag = InlineScriptTag::create('content');

        self::assertNull($tag->getType());
        self::assertSame([], $tag->getAttributes());
    }

    /**
     * @test
     */
    public function it_has_immutable_setters(): void
    {
        $tag = InlineScriptTag::create('content')->withType('type');
        $newTag = $tag->withType('new_type');

        self::assertNotSame($tag, $newTag);
        self::assertSame('type', $tag->getType());
        self::assertSame('new_type', $newTag->getType());
    }
}
