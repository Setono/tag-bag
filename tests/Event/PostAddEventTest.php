<?php

declare(strict_types=1);

namespace Setono\TagBag\Event;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\Rendered\RenderedTag;
use Setono\TagBag\Tag\Tag;
use Setono\TagBag\Tag\TagInterface;
use Setono\TagBag\TagBagInterface;

/**
 * @covers \Setono\TagBag\Event\PostAddEvent
 */
final class PostAddEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_instantiates(): void
    {
        $tag = new class() extends Tag {
        };
        $renderedTag = RenderedTag::createFromTag($tag, 'value', 'fingerprint');

        $tagBag = new class() implements TagBagInterface {
            public function count(): int
            {
                throw new \RuntimeException('Not implemented');
            }

            public function addTag(TagInterface $tag): TagBagInterface
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

            public function getTag(string $name): RenderedTag
            {
                throw new \RuntimeException('Not implemented');
            }

            public function hasTag(string $name): bool
            {
                throw new \RuntimeException('Not implemented');
            }
        };

        $event = new PostAddEvent($renderedTag, $tagBag);
        self::assertSame($renderedTag, $event->getTag());
        self::assertSame($tagBag, $event->getTagBag());
    }
}
