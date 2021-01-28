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
        self::assertInstanceOf(TagInterface::class, $tag);
        self::assertInstanceOf(ScriptTagInterface::class, $tag);
    }

    /**
     * @test
     */
    public function it_has_default_values(): void
    {
        $tag = new ScriptTag('content');

        self::assertSame('setono_tag_bag_script_tag', $tag->getName());
        self::assertNull($tag->getType());
    }

    /**
     * @test
     */
    public function it_mutates(): void
    {
        $tag = new ScriptTag('content');
        $tag->setType('type');

        self::assertSame('type', $tag->getType());
    }
}
