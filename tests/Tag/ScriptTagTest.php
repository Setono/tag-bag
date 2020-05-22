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
        $tag = new ScriptTag('content');
        $this->assertInstanceOf(TagInterface::class, $tag);
        $this->assertInstanceOf(ScriptTagInterface::class, $tag);
    }

    /**
     * @test
     */
    public function it_has_default_values(): void
    {
        $tag = new ScriptTag('content');

        $this->assertSame('setono_tag_bag_script_tag', $tag->getName());
        $this->assertNull($tag->getType());
    }

    /**
     * @test
     */
    public function it_mutates(): void
    {
        $tag = new ScriptTag('content');
        $tag->setType('type');

        $this->assertSame('type', $tag->getType());
    }
}
