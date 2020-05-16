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
        $this->assertInstanceOf(TagInterface::class, new ScriptTag('key', 'content'));
    }

    /**
     * @test
     */
    public function it_has_default_values(): void
    {
        $tag = new ScriptTag('key', 'content');

        $this->assertSame('key', $tag->getKey());
        $this->assertSame('content', $tag->getContent());
        $this->assertSame(TypeAwareInterface::TYPE_SCRIPT, $tag->getType());
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
        $tag = new ScriptTag('key', 'content');
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
