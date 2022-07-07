<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Setono\TagBag\Tag\Tag
 * @covers \Setono\TagBag\Tag\ContentTag
 */
final class ContentTagTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates(): void
    {
        self::assertInstanceOf(TagInterface::class, new ContentTag('content'));
    }

    /**
     * @test
     */
    public function it_has_default_values(): void
    {
        $tag = new ContentTag('content');

        self::assertSame('setono_tag_bag_content_tag', $tag->getName());
        self::assertSame('content', $tag->getContent());
        self::assertSame(TagInterface::SECTION_BODY_END, $tag->getSection());
        self::assertSame(0, $tag->getPriority());
        self::assertTrue($tag->isUnique());
        self::assertCount(0, $tag->getDependencies());
    }

    /**
     * @test
     */
    public function it_is_mutable(): void
    {
        $tag = new ContentTag('content');
        $tag
            ->setContent('new content')
            ->setName('new_name')
            ->setPriority(10)
            ->setSection('section')
            ->addDependency('dependency')
            ->setUnique(true)
        ;

        self::assertSame('new_name', $tag->getName());
        self::assertSame('new content', $tag->getContent());
        self::assertSame('section', $tag->getSection());
        self::assertSame(10, $tag->getPriority());
        self::assertCount(1, $tag->getDependencies());
        self::assertSame('dependency', $tag->getDependencies()[0]);
        self::assertTrue($tag->isUnique());
    }

    /**
     * @test
     */
    public function it_removes_dependencies(): void
    {
        $tag = new ContentTag('content');
        $tag->addDependency('dependency');
        $tag->removeDependency('dependency');

        self::assertCount(0, $tag->getDependencies());
    }

    /**
     * @test
     */
    public function it_does_not_do_anything_if_the_dependency_cannot_be_removed(): void
    {
        $tag = new ContentTag('content');
        $tag->addDependency('dependency');
        $tag->removeDependency('non_existing_dependency');

        self::assertCount(1, $tag->getDependencies());
        self::assertSame('dependency', $tag->getDependencies()[0]);
    }
}
