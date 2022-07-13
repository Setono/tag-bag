<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Setono\TagBag\Tag\Tag
 * @covers \Setono\TagBag\Tag\ContentAwareTag
 */
final class ContentAwareTagTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates(): void
    {
        self::assertInstanceOf(TagInterface::class, ContentAwareTag::create('content'));
        self::assertInstanceOf(ContentAwareInterface::class, ContentAwareTag::create('content'));
    }

    /**
     * @test
     */
    public function it_has_default_values(): void
    {
        $tag = ContentAwareTag::create('content');

        self::assertSame('setono/content-aware-tag', $tag->getName());
        self::assertSame('content', $tag->getContent());
        self::assertSame(TagInterface::SECTION_BODY_END, $tag->getSection());
        self::assertSame(0, $tag->getPriority());
        self::assertTrue($tag->isUnique());
    }

    /**
     * @test
     */
    public function it_is_immutable(): void
    {
        $originalTag = ContentAwareTag::create('content');

        self::assertNotSame($originalTag, $originalTag->withContent('new content'));
        self::assertNotSame($originalTag, $originalTag->withName('new_name'));
        self::assertNotSame($originalTag, $originalTag->withSection('new_section'));
        self::assertNotSame($originalTag, $originalTag->withPriority(10));
        self::assertNotSame($originalTag, $originalTag->unique());
    }
}
