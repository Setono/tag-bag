<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Setono\TagBag\Tag\Tag
 */
final class TagTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates(): void
    {
        $this->assertInstanceOf(TagInterface::class, Tag::create('key'));
    }

    /**
     * @test
     */
    public function it_has_default_values(): void
    {
        $tag = Tag::create('key');

        $this->assertSame('key', $tag->getKey());
        $this->assertNull($tag->getSection());
        $this->assertSame(0, $tag->getPriority());
        $this->assertIsArray($tag->getDependents());
        $this->assertCount(0, $tag->getDependents());
        $this->assertTrue($tag->willReplace());
    }

    /**
     * @test
     */
    public function it_is_mutable(): void
    {
        $tag = Tag::create('key');
        $tag
            ->setPriority(10)
            ->setSection('section')
            ->setReplace(false)
            ->addDependent('dependent')
        ;

        $this->assertSame('section', $tag->getSection());
        $this->assertSame(10, $tag->getPriority());
        $this->assertIsArray($tag->getDependents());
        $this->assertCount(1, $tag->getDependents());
        $this->assertSame('dependent', $tag->getDependents()[0]);
    }
}
