<?php

declare(strict_types=1);

namespace Setono\TagBag\Event;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\ContentAwareTag;

/**
 * @covers \Setono\TagBag\Event\PreTagAddedEvent
 */
final class PreTagAddedEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_instantiates(): void
    {
        $tag = ContentAwareTag::create('content');
        $event = new PreTagAddedEvent($tag);
        self::assertSame($tag, $event->tag);
    }
}
