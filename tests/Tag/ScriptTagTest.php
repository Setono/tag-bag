<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

use PHPUnit\Framework\TestCase;

final class ScriptTagTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates(): void
    {
        $tag = ScriptTag::create('https://example.com/script.js');

        self::assertInstanceOf(TagInterface::class, $tag);
        self::assertInstanceOf(ContentAwareInterface::class, $tag);
        self::assertInstanceOf(AttributesAwareInterface::class, $tag);
    }

    /**
     * @test
     */
    public function it_has_default_values(): void
    {
        $tag = ScriptTag::create('https://example.com/script.js');

        self::assertSame('https://example.com/script.js', $tag->getSrc());
        self::assertNull($tag->getType());
        self::assertFalse($tag->isDeferred());
        self::assertFalse($tag->isAsync());
    }

    /**
     * @test
     */
    public function it_has_immutable_setters(): void
    {
        $tag = ScriptTag::create('https://example.com/script.js')->withType('type');
        $newTag = $tag->withSrc('https://example.com/script2.js')->withType('new_type')->async()->defer();

        self::assertNotSame($tag, $newTag);

        self::assertSame('type', $tag->getType());
        self::assertSame('new_type', $newTag->getType());

        self::assertSame('https://example.com/script.js', $tag->getSrc());
        self::assertSame('https://example.com/script2.js', $newTag->getSrc());

        self::assertFalse($tag->isAsync());
        self::assertTrue($newTag->isAsync());

        self::assertFalse($tag->isDeferred());
        self::assertTrue($newTag->isDeferred());
    }
}
