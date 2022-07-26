<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

use PHPUnit\Framework\TestCase;

final class LinkTagTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates(): void
    {
        $tag = LinkTag::create('stylesheet', 'https://example.com/style.css');

        self::assertInstanceOf(TagInterface::class, $tag);
        self::assertInstanceOf(ContentAwareInterface::class, $tag);
        self::assertInstanceOf(AttributesAwareInterface::class, $tag);
    }

    /**
     * @test
     */
    public function it_has_default_values(): void
    {
        $tag = LinkTag::create('stylesheet', 'https://example.com/style.css');

        self::assertSame('stylesheet', $tag->getRel());
        self::assertSame('https://example.com/style.css', $tag->getHref());
    }

    /**
     * @test
     */
    public function it_has_immutable_setters(): void
    {
        $tag = LinkTag::create('stylesheet', 'https://example.com/style.css');
        $newTag = $tag->withHref('https://example.com/style2.css')->withRel('new_rel');

        self::assertNotSame($tag, $newTag);
        self::assertSame('stylesheet', $tag->getRel());
        self::assertSame('new_rel', $newTag->getRel());
        self::assertSame('https://example.com/style.css', $tag->getHref());
        self::assertSame('https://example.com/style2.css', $newTag->getHref());
    }
}
