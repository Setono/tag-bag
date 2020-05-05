<?php

declare(strict_types=1);

namespace Setono\TagBag\TagBag;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Renderer\RendererInterface;
use Setono\TagBag\Storage\InMemoryStorage;
use Setono\TagBag\Tag\Rendered\RenderedTagInterface;
use Setono\TagBag\Tag\Section\SectionInterface;
use Setono\TagBag\Tag\Tag;
use Setono\TagBag\Tag\TagInterface;

final class TagBagTest extends TestCase
{
    /**
     * @test
     */
    public function it_adds_tag(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->addTag(Tag::create('key'));

        $this->assertCount(1, $tagBag);

        $tags = $tagBag->getTags();

        $this->assertIsArray($tags);

        // asserting the number of sections
        $this->assertCount(1, $tags);
        $this->assertContainsOnlyInstancesOf(SectionInterface::class, $tags);

        $section = current($tags);
        $this->assertCount(1, $section);

        foreach ($section as $tag) {
            $this->assertInstanceOf(RenderedTagInterface::class, $tag);
        }

        $this->assertSame('content', (string) $section);
    }

    private function getTagBag(): TagBagInterface
    {
        $renderer = new class() implements RendererInterface {
            public function supports(TagInterface $tag): bool
            {
                return true;
            }

            public function render(TagInterface $tag): string
            {
                return 'content';
            }
        };

        return new TagBag($renderer, new InMemoryStorage());
    }
}
