<?php

declare(strict_types=1);

namespace Setono\TagBag\Event;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Renderer\ContentRenderer;
use Setono\TagBag\Tag\ContentAwareTag;
use Setono\TagBag\Tag\Rendered\RenderedTag;
use Setono\TagBag\TagBag;

/**
 * @covers \Setono\TagBag\Event\TagAddedEvent
 */
final class TagAddedEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_instantiates(): void
    {
        $tag = ContentAwareTag::create('value');
        $renderedTag = RenderedTag::createFromTag($tag, 'value', 'fingerprint');
        $tagBag = new TagBag(new ContentRenderer());

        $event = new TagAddedEvent($renderedTag, $tagBag);
        self::assertSame($renderedTag, $event->tag);
        self::assertSame($tagBag, $event->tagBag);
    }
}
