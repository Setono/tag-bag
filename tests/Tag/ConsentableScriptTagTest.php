<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

use PHPUnit\Framework\TestCase;

final class ConsentableScriptTagTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates(): void
    {
        $tag = ConsentableScriptTag::create('https://example.com/script.js');

        self::assertInstanceOf(TagInterface::class, $tag);
        self::assertInstanceOf(ContentAwareInterface::class, $tag);
        self::assertInstanceOf(AttributesAwareInterface::class, $tag);
    }

    /**
     * @test
     */
    public function it_has_default_values(): void
    {
        $tag = ConsentableScriptTag::create('https://example.com/script.js', 'marketing');

        self::assertSame('https://example.com/script.js', $tag->getSrc());
        self::assertSame('text/plain', $tag->getType());
        self::assertSame('marketing', $tag->getAttribute('data-consent'));
    }

    /**
     * @test
     */
    public function it_has_immutable_setters(): void
    {
        $tag = ConsentableScriptTag::create('https://example.com/script.js')->withType('type');
        $newTag = $tag->withSrc('https://example.com/script2.js')->withType('new_type');

        self::assertNotSame($tag, $newTag);

        self::assertSame('type', $tag->getType());
        self::assertSame('new_type', $newTag->getType());

        self::assertSame('https://example.com/script.js', $tag->getSrc());
        self::assertSame('https://example.com/script2.js', $newTag->getSrc());
    }
}
