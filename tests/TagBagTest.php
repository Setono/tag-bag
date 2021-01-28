<?php

declare(strict_types=1);

namespace Setono\TagBag;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Setono\TagBag\Exception\UnsupportedTagException;
use Setono\TagBag\Generator\ValueBasedFingerprintGenerator;
use Setono\TagBag\Renderer\RendererInterface;
use Setono\TagBag\Storage\InMemoryStorage;
use Setono\TagBag\Storage\StorageInterface;
use Setono\TagBag\Tag\ContentAwareInterface;
use Setono\TagBag\Tag\Rendered\RenderedTag;
use Setono\TagBag\Tag\Tag;
use Setono\TagBag\Tag\TagInterface;

/**
 * @covers \Setono\TagBag\TagBag
 */
final class TagBagTest extends TestCase
{
    /** @var LoggerInterface */
    private $logger;

    protected function setUp(): void
    {
        $this->logger = new class() extends AbstractLogger {
            private $messages = [];

            public function log($level, $message, array $context = []): void
            {
                $this->messages[] = [
                    'level' => $level,
                    'message' => $message,
                    'context' => $context,
                ];
            }

            public function getMessages(): array
            {
                return $this->messages;
            }
        };
    }

    /**
     * @test
     */
    public function the_tag_bag_is_empty(): void
    {
        $tagBag = $this->getTagBag();
        self::assertCount(0, $tagBag);
    }

    /**
     * @test
     */
    public function it_adds_tag(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->addTag($this->getTag());

        self::assertCount(1, $tagBag);

        $tags = $tagBag->getAll();

        $this->defaultTagsAssertions($tags);
    }

    /**
     * @test
     */
    public function it_does_not_add_tag_if_tag_is_unique_and_already_exists(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->addTag($this->getTag()->setUnique(true));
        $tagBag->addTag($this->getTag());

        self::assertCount(1, $tagBag);

        $tags = $tagBag->getAll();

        $this->defaultTagsAssertions($tags);
    }

    /**
     * @test
     */
    public function it_returns_tag_when_trying_to_get_existing_tag(): void
    {
        $tag = $this->getTag();

        $tagBag = $this->getTagBag();
        $tagBag->addTag($tag->setName('tag_name'));

        self::assertSame($tag->getName(), $tagBag->getTag('tag_name')->getName());
    }

    /**
     * @test
     */
    public function it_throws_when_trying_to_get_non_existing_tag(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $tagBag = $this->getTagBag();
        $tagBag->addTag($this->getTag()->setName('tag_name'));

        $tagBag->getTag('non_existing_tag_name');
    }

    /**
     * @test
     */
    public function it_returns_true_if_asked_if_existing_tag_exists(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->addTag($this->getTag()->setName('tag_name'));

        self::assertTrue($tagBag->hasTag('tag_name'));
    }

    /**
     * @test
     */
    public function it_returns_false_if_asked_if_non_existing_tag_exists(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->addTag($this->getTag()->setName('tag_name'));

        self::assertFalse($tagBag->hasTag('non_existing_tag_name'));
    }

    /**
     * @test
     */
    public function it_returns_a_section(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->addTag($this->getTag()->setSection('section'));

        $section = $tagBag->getSection('section');

        self::assertIsArray($section);
        self::assertCount(1, $section);
    }

    /**
     * @test
     */
    public function it_renders_empty_string_if_section_does_not_exist(): void
    {
        $tagBag = $this->getTagBag();
        self::assertSame('', $tagBag->renderSection('non_existing_section'));
    }

    /**
     * @test
     */
    public function it_renders_a_section_and_removes_rendered_section(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->addTag($this->getTag('content1')->setSection('section1'));
        $tagBag->addTag($this->getTag('content2')->setSection('section2'));

        // before the section is rendered, the count should be 2
        self::assertCount(2, $tagBag);
        self::assertSame('content1', $tagBag->renderSection('section1'));

        // after the section is rendered, the count should be 1,
        // because the renderSection call should remove the given section from the tag bag
        self::assertCount(1, $tagBag);
    }

    /**
     * @test
     */
    public function it_renders_all_tags_and_resets_the_tag_bag(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->addTag($this->getTag('content1')->setSection('section1'));
        $tagBag->addTag($this->getTag('content2')->setSection('section2'));

        self::assertSame('content1content2', $tagBag->renderAll());

        // after the section is rendered, the count should be 1,
        // because the renderSection call should remove the given section from the tag bag
        self::assertCount(0, $tagBag);
    }

    /**
     * @test
     */
    public function it_throws_if_the_section_does_not_exist(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $tagBag = $this->getTagBag();
        $tagBag->addTag($this->getTag()->setSection('section'));

        $tagBag->getSection('non_existing_section');
    }

    /**
     * @test
     */
    public function it_sorts_tags(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag
            ->addTag($this->getTag('content1')->setPriority(-10)->setName('key3'))
            ->addTag($this->getTag('content2')->setPriority(10)->setName('key1'))
            ->addTag($this->getTag('content3')->setName('key2'))
        ;

        $section = $tagBag->getSection(TagInterface::SECTION_BODY_END);

        $i = 1;
        foreach ($section as $tag) {
            self::assertSame('key' . $i++, $tag->getName());
        }
    }

    /**
     * @test
     */
    public function it_adds_tag_with_dependency(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag
            ->addTag($this->getTag('content1')->setName('dependency'))
            ->addTag($this->getTag('content2')->addDependency('dependency'))
        ;

        self::assertCount(2, $tagBag);
    }

    /**
     * @test
     */
    public function it_throws_exception_if_dependency_does_not_exist(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->addTag($this->getTag()->addDependency('dependency'));

        $tagBag->renderAll();

        $messages = $this->logger->getMessages();
        self::assertCount(1, $messages);

        $message = $messages[0];

        self::assertSame('[Tag Bag] Non existing tags that some other tag depended on: [dependency]', $message['message']);
    }

    /**
     * @test
     */
    public function it_does_not_throw_when_dependency_is_present_in_not_rendered_tags(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->addTag($this->getTag('content1')->addDependency('dependency'));
        $tagBag->addTag($this->getTag('content2')->setName('dependency'));

        self::assertSame('content1content2', $tagBag->renderAll());
    }

    /**
     * @test
     */
    public function it_does_not_throw_when_dependency_is_present_in_already_rendered_tags(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->addTag($this->getTag('content1')->addDependency('dependency'));
        $tagBag->addTag($this->getTag('content2')->setName('dependency')->setSection(TagInterface::SECTION_HEAD));

        $tagBag->renderSection(TagInterface::SECTION_HEAD);

        self::assertSame('content1', $tagBag->renderAll());
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

        self::assertNull($storage->restore());
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

        self::assertCount(0, $tagBag);
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
        self::assertIsArray($tags);

        // asserting the number of sections
        self::assertCount(1, $tags);

        $section = current($tags);
        self::assertCount(1, $section);

        foreach ($section as $tag) {
            self::assertInstanceOf(RenderedTag::class, $tag);
        }
    }

    private function getTag(string $content = 'content'): Tag
    {
        return new class($content) extends Tag implements ContentAwareInterface {
            private $content;

            public function __construct(string $content)
            {
                $this->content = $content;
            }

            public function getContent(): string
            {
                return $this->content;
            }
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
                    if ($tag instanceof ContentAwareInterface) {
                        return $tag->getContent();
                    }

                    return 'content';
                }
            };
        }

        $eventDispatcher = new class() implements EventDispatcherInterface {
            public function dispatch(object $event): void
            {
            }
        };

        return new TagBag($renderer, $storage ?? new InMemoryStorage(), $eventDispatcher, new ValueBasedFingerprintGenerator(), $this->logger);
    }
}
