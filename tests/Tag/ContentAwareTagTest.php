<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

use PHPUnit\Framework\TestCase;

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

        self::assertSame('content', $tag->getContent());
        self::assertSame(TagInterface::SECTION_BODY_END, $tag->getSection());
        self::assertSame(0, $tag->getPriority());
        self::assertTrue($tag->isUnique());
        self::assertNull($tag->getFingerprint());
    }

    /**
     * @test
     */
    public function it_has_immutable_setters(): void
    {
        $tag = ContentAwareTag::create('content');
        $newTag = $tag->withContent('new content')
            ->withSection('new_section')
            ->withPriority(10)
            ->withFingerprint('fingerprint')
            ->notUnique()
        ;

        self::assertNotSame($tag, $newTag);

        self::assertSame('content', $tag->getContent());
        self::assertSame(TagInterface::SECTION_BODY_END, $tag->getSection());
        self::assertSame(0, $tag->getPriority());
        self::assertNull($tag->getFingerprint());
        self::assertTrue($tag->isUnique());

        self::assertSame('new content', $newTag->getContent());
        self::assertSame('new_section', $newTag->getSection());
        self::assertSame(10, $newTag->getPriority());
        self::assertSame('fingerprint', $newTag->getFingerprint());
        self::assertFalse($newTag->isUnique());
    }
}
