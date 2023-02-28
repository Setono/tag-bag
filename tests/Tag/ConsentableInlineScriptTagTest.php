<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

use PHPUnit\Framework\TestCase;

final class ConsentableInlineScriptTagTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates(): void
    {
        $tag = ConsentableInlineScriptTag::create('function track() {}');

        self::assertInstanceOf(TagInterface::class, $tag);
        self::assertInstanceOf(ContentAwareInterface::class, $tag);
        self::assertInstanceOf(AttributesAwareInterface::class, $tag);
    }

    /**
     * @test
     */
    public function it_has_default_values(): void
    {
        $tag = ConsentableInlineScriptTag::create('function track() {}', 'marketing');

        self::assertSame('text/plain', $tag->getType());
        self::assertSame('marketing', $tag->getAttribute('data-consent'));
    }

    /**
     * @test
     */
    public function it_has_immutable_setters(): void
    {
        $tag = ConsentableInlineScriptTag::create('function track() {}')->withType('type');
        $newTag = $tag->withType('new_type');

        self::assertNotSame($tag, $newTag);

        self::assertSame('type', $tag->getType());
        self::assertSame('new_type', $newTag->getType());
    }
}
