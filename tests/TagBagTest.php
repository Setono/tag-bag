<?php

declare(strict_types=1);

namespace Setono\TagBag;

use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Setono\TagBag\Exception\NonExistingTagsException;
use Setono\TagBag\Exception\UnsupportedTagException;
use Setono\TagBag\Renderer\RendererInterface;
use Setono\TagBag\Storage\InMemoryStorage;
use Setono\TagBag\Storage\StorageInterface;
use Setono\TagBag\Tag\Rendered\RenderedTag;
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
     */
    public function it_adds_tag(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->addTag($this->getTag());

        $this->assertCount(1, $tagBag);

        $tags = $tagBag->getAll();

        $this->defaultTagsAssertions($tags);
    }

    /**
     * @test
     */
    public function it_returns_a_section(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->addTag($this->getTag()->setSection('section'));

        $section = $tagBag->getSection('section');

        $this->assertIsArray($section);
        $this->assertCount(1, $section);
    }

    /**
     * @test
     */
    public function it_renders_a_section_and_removes_rendered_section(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->addTag($this->getTag()->setSection('section1'));
        $tagBag->addTag($this->getTag()->setSection('section2'));

        // before the section is rendered, the count should be 2
        $this->assertCount(2, $tagBag);
        $this->assertSame('content', $tagBag->renderSection('section1'));

        // after the section is rendered, the count should be 1,
        // because the renderSection call should remove the given section from the tag bag
        $this->assertCount(1, $tagBag);
    }

    /**
     * @test
     */
    public function it_renders_all_tags_and_resets_the_tag_bag(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->addTag($this->getTag()->setSection('section1'));
        $tagBag->addTag($this->getTag()->setSection('section2'));

        $this->assertSame('contentcontent', $tagBag->renderAll());

        // after the section is rendered, the count should be 1,
        // because the renderSection call should remove the given section from the tag bag
        $this->assertCount(0, $tagBag);
    }

    /**
     * @test
     */
    public function it_returns_null_if_the_section_does_not_exist(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->addTag($this->getTag()->setSection('section'));

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
            ->addTag($this->getTag()->setPriority(-10)->setName('key3'))
            ->addTag($this->getTag()->setPriority(10)->setName('key1'))
            ->addTag($this->getTag()->setName('key2'))
        ;

        $section = $tagBag->getSection(TagInterface::SECTION_BODY_END);

        $i = 1;
        foreach ($section as $tag) {
            $this->assertSame('key' . $i++, $tag->getName());
        }
    }

    /**
     * @test
     */
    public function it_adds_tag_with_dependency(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag
            ->addTag($this->getTag()->setName('dependency'))
            ->addTag($this->getTag()->addDependency('dependency'))
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
        $tagBag->addTag($this->getTag()->addDependency('dependent'));
    }

    /**
     * @test
     */
    public function it_stores_and_restores(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->addTag($this->getTag());

        $tagBag->store();
        $tagBag->restore();

        $tags = $tagBag->getAll();

        $this->defaultTagsAssertions($tags);
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
        $tagBag->addTag(new class() extends Tag {
        });

        $tagBag->restore();

        $this->assertCount(0, $tagBag);
    }

    /**
     * @test
     */
    public function it_throws_exception_if_tag_is_not_supported(): void
    {
        $renderer = new class() implements RendererInterface {
            public function supports(TagInterface $tag): bool
            {
                return false;
            }

            public function render(TagInterface $tag): string
            {
                return 'content';
            }
        };

        $this->expectException(UnsupportedTagException::class);
        $tagBag = $this->getTagBag(null, $renderer);
        $tagBag->addTag($this->getTag());
    }

    private function defaultTagsAssertions(array $tags): void
    {
        $this->assertIsArray($tags);

        // asserting the number of sections
        $this->assertCount(1, $tags);

        $section = current($tags);
        $this->assertCount(1, $section);

        foreach ($section as $tag) {
            $this->assertInstanceOf(RenderedTag::class, $tag);
        }
    }

    private function getTag(): Tag
    {
        return new class() extends Tag {
        };
    }

    private function getTagBag(StorageInterface $storage = null, RendererInterface $renderer = null): TagBagInterface
    {
        if (null === $renderer) {
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
        }

        $eventDispatcher = new class() implements EventDispatcherInterface {
            public function dispatch(object $event): void
            {
                // TODO: Implement dispatch() method.
            }
        };

        return new TagBag($renderer, $storage ?? new InMemoryStorage(), $eventDispatcher);
    }
}
