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
        $this->assertInstanceOf(TagInterface::class, new ScriptTag('content'));
    }

    /**
     * @test
     */
    public function it_has_default_values(): void
    {
        $tag = new ScriptTag('content');

        $this->assertSame('setono_tag_bag_script_tag', $tag->getName());
        $this->assertSame(TypeAwareInterface::TYPE_SCRIPT, $tag->getType());
    }
}
