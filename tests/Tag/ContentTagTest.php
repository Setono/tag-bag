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
        $this->assertInstanceOf(TagInterface::class, new ContentTag('content'));
    }

    /**
     * @test
     */
    public function it_has_default_values(): void
    {
        $tag = new ContentTag('content');

        $this->assertSame('setono_tag_bag_content_tag', $tag->getName());
        $this->assertSame('content', $tag->getContent());
        $this->assertNull($tag->getSection());
        $this->assertSame(0, $tag->getPriority());
        $this->assertIsArray($tag->getDependencies());
        $this->assertCount(0, $tag->getDependencies());
    }

    /**
     * @test
     */
    public function it_is_mutable(): void
    {
        $tag = new ContentTag('content');
        $tag
            ->setName('new_name')
            ->setContent('new content')
            ->setPriority(10)
            ->setSection('section')
            ->addDependency('dependent')
        ;

        $this->assertSame('new_name', $tag->getName());
        $this->assertSame('new content', $tag->getContent());
        $this->assertSame('section', $tag->getSection());
        $this->assertSame(10, $tag->getPriority());
        $this->assertIsArray($tag->getDependencies());
        $this->assertCount(1, $tag->getDependencies());
        $this->assertSame('dependent', $tag->getDependencies()[0]);
    }
}
