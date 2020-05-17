<?php

declare(strict_types=1);

namespace Setono\TagBag\Event;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\Tag;

/**
 * @covers \Setono\TagBag\Event\PreRenderEvent
 */
final class PreRenderEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_instantiates(): void
    {
        $tag = new class() extends Tag {
        };
        $event = new PreRenderEvent($tag);
        $this->assertSame($tag, $event->getTag());
    }
}
