<?php

declare(strict_types=1);

namespace Setono\TagBag\Event;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\ContentAwareTag;
use Setono\TagBag\Tag\Rendered\RenderedTag;
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
        $tag = ContentAwareTag::create('value');
        $renderedTag = RenderedTag::createFromTag($tag, 'value', 'fingerprint');

        $tagBag = new class() implements TagBagInterface {
            public function count(): int
            {
                throw new \RuntimeException('Not implemented');
            }

            public function add(TagInterface $tag): void
            {
                throw new \RuntimeException('Not implemented');
            }

            public function getAll(): array
            {
                throw new \RuntimeException('Not implemented');
            }

            public function getSection(string $section): array
            {
                throw new \RuntimeException('Not implemented');
            }

            public function hasSection(string $section): bool
            {
                throw new \RuntimeException('Not implemented');
            }

            public function renderAll(): string
            {
                throw new \RuntimeException('Not implemented');
            }

            public function renderSection(string $section): string
            {
                throw new \RuntimeException('Not implemented');
            }

            public function store(): void
            {
            }

            public function restore(): void
            {
            }

            public function get(string $name): RenderedTag
            {
                throw new \RuntimeException('Not implemented');
            }

            public function has(string $name): bool
            {
                throw new \RuntimeException('Not implemented');
            }
        };

        $event = new TagAddedEvent($renderedTag, $tagBag);
        self::assertSame($renderedTag, $event->tag);
        self::assertSame($tagBag, $event->tagBag);
    }
}
