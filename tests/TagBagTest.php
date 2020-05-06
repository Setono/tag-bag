<?php

declare(strict_types=1);

namespace Setono\TagBag;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Exception\NonExistingTagsException;
use Setono\TagBag\Renderer\RendererInterface;
use Setono\TagBag\Storage\InMemoryStorage;
use Setono\TagBag\Storage\StorageInterface;
use Setono\TagBag\Tag\Rendered\RenderedTagInterface;
use Setono\TagBag\Tag\Section\SectionInterface;
use Setono\TagBag\Tag\Tag;
use Setono\TagBag\Tag\TagInterface;

/**
 * @covers \Setono\TagBag\TagBag
 */
final class TagBagTest extends TestCase
{
    /**
     * @test
     */
    public function the_tag_bag_is_empty(): void
    {
        $tagBag = $this->getTagBag();
        $this->assertCount(0, $tagBag);
    }

    /**
     * @test
     *
     * This test performs a lot of assertions about the behavior of the tag bag
     */
    public function it_adds_tag(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->addTag(new Tag('key'));

        $this->assertCount(1, $tagBag);

        $tags = $tagBag->getAll();

        $this->default_tags_assertions($tags);
    }

    /**
     * @test
     */
    public function it_returns_a_section(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->addTag((new Tag('key'))->setSection('section'));

        $section = $tagBag->getSection('section');

        $this->assertInstanceOf(SectionInterface::class, $section);

        $this->assertSame('content', (string) $section);
    }

    /**
     * @test
     */
    public function it_returns_null_if_the_section_does_not_exist(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->addTag((new Tag('key'))->setSection('section'));

        $section = $tagBag->getSection('non_existing_section');

        $this->assertNull($section);
    }

    /**
     * @test
     */
    public function it_sorts_tags(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag
            ->addTag((new Tag('key3'))->setPriority(-10))
            ->addTag((new Tag('key1'))->setPriority(10))
            ->addTag((new Tag('key2')))
        ;

        $section = $tagBag->getSection(TagBagInterface::DEFAULT_SECTION);

        $i = 1;
        foreach ($section as $key => $tag) {
            $this->assertSame('key' . $i++, $key);
        }
    }

    /**
     * @test
     */
    public function it_adds_tag_with_dependent(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag
            ->addTag(new Tag('dependent'))
            ->addTag((new Tag('key'))->addDependent('dependent'))
        ;

        $this->assertCount(2, $tagBag);
    }

    /**
     * @test
     */
    public function it_throws_exception_if_dependent_does_not_exist(): void
    {
        $this->expectException(NonExistingTagsException::class);

        $tagBag = $this->getTagBag();
        $tagBag->addTag((new Tag('key'))->addDependent('dependent'));
    }

    /**
     * @test
     */
    public function it_stores_and_restores(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->addTag(new Tag('key'));

        $tagBag->store();
        $tagBag->restore();

        $tags = $tagBag->getAll();

        $this->default_tags_assertions($tags);
    }

    /**
     * @test
     */
    public function it_does_not_store_when_tag_bag_is_empty(): void
    {
        $storage = new InMemoryStorage();

        $tagBag = $this->getTagBag($storage);

        $tagBag->store();

        $this->assertNull($storage->restore());
    }

    /**
     * @test
     */
    public function it_does_not_restore_when_storage_is_null(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->addTag(new Tag('key'));

        $tagBag->restore();

        $this->assertCount(0, $tagBag);
    }

    private function default_tags_assertions(array $tags): void
    {
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

    private function getTagBag(StorageInterface $storage = null): TagBagInterface
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

        return new TagBag($renderer, $storage ?? new InMemoryStorage());
    }
}
