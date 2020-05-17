<?php

declare(strict_types=1);

namespace Setono\TagBag\Event;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\Rendered\RenderedTag;
use Setono\TagBag\Tag\Tag;
use Setono\TagBag\Tag\TagInterface;
use Setono\TagBag\TagBagInterface;

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
        $tag = new class() extends Tag {
        };
        $renderedTag = RenderedTag::createFromTag($tag, 'value');

        $tagBag = new class() implements TagBagInterface {
            public function count(): int
            {
                return 0;
            }

            public function addTag(TagInterface $tag): TagBagInterface
            {
                return $this;
            }

            public function getAll(): array
            {
                return [];
            }

            public function getSection(string $section): ?array
            {
                return null;
            }

            public function renderAll(): string
            {
                return '';
            }

            public function renderSection(string $section): string
            {
                return '';
            }

            public function store(): void
            {
                // TODO: Implement store() method.
            }

            public function restore(): void
            {
                // TODO: Implement restore() method.
            }
        };

        $event = new TagAddedEvent($renderedTag, $tagBag);
        $this->assertSame($renderedTag, $event->getTag());
        $this->assertSame($tagBag, $event->getTagBag());
    }
}
