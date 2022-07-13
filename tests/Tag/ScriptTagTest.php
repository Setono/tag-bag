<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Setono\TagBag\Tag\ScriptTag
 */
final class ScriptTagTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates(): void
    {
        $tag = ScriptTag::create('content');
        self::assertInstanceOf(TagInterface::class, $tag);
        self::assertInstanceOf(ContentAwareInterface::class, $tag);
        self::assertInstanceOf(AttributesAwareInterface::class, $tag);
        self::assertInstanceOf(ScriptTagInterface::class, $tag);
    }

    /**
     * @test
     */
    public function it_has_default_values(): void
    {
        $tag = ScriptTag::create('content');

        self::assertSame('setono/script-tag', $tag->getName());
        self::assertNull($tag->getType());
        self::assertSame([], $tag->getAttributes());
    }

    /**
     * @test
     */
    public function it_mutates(): void
    {
        $tag = ScriptTag::create('content')->withType('type');

        self::assertSame('type', $tag->getType());
    }
}
