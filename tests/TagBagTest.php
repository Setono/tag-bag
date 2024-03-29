<?php

declare(strict_types=1);

namespace Setono\TagBag;

use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\AbstractLogger;
use RuntimeException;
use Setono\TagBag\Event\PreTagAddedEvent;
use Setono\TagBag\Event\TagAddedEvent;
use Setono\TagBag\Exception\UnsupportedTagException;
use Setono\TagBag\Renderer\RendererInterface;
use Setono\TagBag\Storage\InMemoryStorage;
use Setono\TagBag\Storage\StorageInterface;
use Setono\TagBag\Tag\ContentAwareInterface;
use Setono\TagBag\Tag\ContentTag;
use Setono\TagBag\Tag\TagInterface;

/**
 * @covers \Setono\TagBag\TagBag
 */
final class TagBagTest extends TestCase
{
    private TestLogger $logger;

    protected function setUp(): void
    {
        $this->logger = new TestLogger();
    }

    /**
     * @test
     */
    public function it_does_not_add_tag_if_tag_is_unique_and_already_exists(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->add($this->getTag('unique_content'));
        $tagBag->add($this->getTag('unique_content'));
        self::assertSame('unique_content', $tagBag->renderAll());
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
        $tagBag->add($this->getTag('content1', 'section1'));
        $tagBag->add($this->getTag('content2', 'section2'));

        self::assertSame('content1', $tagBag->renderSection('section1'));

        // after section1 has been rendered, that section should be empty,
        // and we should get an empty string when we try to render section1 again
        self::assertSame('', $tagBag->renderSection('section1'));

        self::assertSame('content2', $tagBag->renderSection('section2'));
    }

    /**
     * @test
     */
    public function it_renders_all_tags_and_resets_the_tag_bag(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->add($this->getTag('content1', 'section1'));
        $tagBag->add($this->getTag('content2', 'section2'));

        self::assertSame('content1content2', $tagBag->renderAll());

        // after all sections are rendered, the tag bag should be empty,
        // and we should get an empty string when we try to render all sections again
        self::assertSame('', $tagBag->renderAll());
    }

    /**
     * @test
     */
    public function it_stores_and_restores(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->add($this->getTag());

        $tagBag->store();
        $tagBag->restore();

        self::assertSame('content', $tagBag->renderAll());
    }

    /**
     * @test
     */
    public function it_does_not_store_anything_when_tag_bag_is_empty(): void
    {
        $storage = new InMemoryStorage();
        $tagBag = $this->getTagBag($storage);

        $tagBag->store();

        self::assertNull($storage->restore());
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
        $tagBag->add($this->getTag());
    }

    /**
     * @test
     */
    public function it_sorts_tags(): void
    {
        $tagBag = $this->getTagBag();
        $tagBag->add($this->getTag('content1')->withPriority(0));
        $tagBag->add($this->getTag('content2')->withPriority(10));

        self::assertSame('content2content1', $tagBag->renderAll());
    }

    /**
     * @test
     */
    public function it_dispatches_events(): void
    {
        $eventDispatcher = new class() implements EventDispatcherInterface {
            public array $dispatchedEvents = [];

            public function dispatch(object $event): void
            {
                $this->dispatchedEvents[] = $event;
            }
        };
        $tag = $this->getTag();
        $tagBag = $this->getTagBag();
        $tagBag->setEventDispatcher($eventDispatcher);
        $tagBag->add($tag);

        self::assertCount(2, $eventDispatcher->dispatchedEvents);

        [$firstEvent, $secondEvent] = $eventDispatcher->dispatchedEvents;

        self::assertInstanceOf(PreTagAddedEvent::class, $firstEvent);
        self::assertInstanceOf(TagAddedEvent::class, $secondEvent);
    }

    /**
     * @test
     */
    public function it_uses_set_fingerprint_for_uniqueness(): void
    {
        $tag1 = $this->getTag('some content')->withFingerprint('fingerprint');
        $tag2 = $this->getTag('other content')->withFingerprint('fingerprint');

        $tagBag = $this->getTagBag();
        $tagBag->add($tag1);
        $tagBag->add($tag2);

        self::assertSame('some content', $tagBag->renderAll());
    }

    /**
     * @test
     */
    public function it_ignores_fingerprint_when_both_tags_are_not_unique(): void
    {
        $tag1 = $this->getTag()->notUnique();
        $tag2 = $this->getTag()->notUnique();

        $tagBag = $this->getTagBag();
        $tagBag->add($tag1);
        $tagBag->add($tag2);

        self::assertSame('contentcontent', $tagBag->renderAll());
    }

    /**
     * @test
     */
    public function it_does_not_ignore_fingerprint_when_one_of_the_tags_is_unique(): void
    {
        $tag1 = $this->getTag()->unique();
        $tag2 = $this->getTag()->notUnique();

        $tagBag = $this->getTagBag();
        $tagBag->add($tag1);
        $tagBag->add($tag2);

        self::assertSame('content', $tagBag->renderAll());
    }

    /**
     * @test
     */
    public function it_replaces_unique_tag_with_new_one_with_higher_priority(): void
    {
        $tag1 = $this->getTag('tag1')->unique()->withPriority(10)->withFingerprint('tag');
        $tag2 = $this->getTag('tag2')->unique()->withPriority(20)->withFingerprint('tag');

        $tagBag = $this->getTagBag();
        $tagBag->add($tag1);
        $tagBag->add($tag2);

        self::assertSame('tag2', $tagBag->renderAll());
    }

    /**
     * @test
     */
    public function it_replaces_non_unique_existing_tag_with_new_unique_tag(): void
    {
        $tag1 = $this->getTag('tag1')->notUnique()->withPriority(30)->withFingerprint('tag');
        $tag2 = $this->getTag('tag2')->unique()->withPriority(20)->withFingerprint('tag');

        $tagBag = $this->getTagBag();
        $tagBag->add($tag1);
        $tagBag->add($tag2);

        self::assertSame('tag2', $tagBag->renderAll());
    }

    /**
     * @test
     */
    public function it_handles_exceptions_when_trying_to_add_a_tag(): void
    {
        $renderer = new class() implements RendererInterface {
            public function supports(TagInterface $tag): bool
            {
                return true;
            }

            public function render(TagInterface $tag): string
            {
                throw new RuntimeException('Cannot render tag');
            }
        };

        $tagBag = $this->getTagBag(null, $renderer);
        $tagBag->add($this->getTag());

        self::assertTrue($this->logger->hasMessageMatching('/^Cannot render tag$/'));
    }

    /**
     * @test
     */
    public function it_catches_unserialize_error(): void
    {
        $storage = new class() implements StorageInterface {
            public function store(string $data): void
            {
            }

            public function restore(): ?string
            {
                return serialize([
                    new NotARenderedTag(),
                ]);
            }

            public function remove(): void
            {
            }
        };
        $tagBag = $this->getTagBag($storage);
        $tagBag->restore();

        self::assertTrue($this->logger->hasMessageMatching('/^Exception thrown when trying to unserialize data/'));
    }

    private function getTag(
        string $content = 'content',
        string $section = null,
        bool $unique = true
    ): ContentTag {
        $tag = ContentTag::create($content);

        if (null !== $section) {
            $tag = $tag->withSection($section);
        }

        return $tag->withUnique($unique);
    }

    private function getTagBag(StorageInterface $storage = null, RendererInterface $renderer = null): TagBag
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

        $tagBag = new TagBag($renderer);
        $tagBag->setStorage($storage ?? new InMemoryStorage());
        $tagBag->setEventDispatcher($eventDispatcher);
        $tagBag->setLogger($this->logger);

        return $tagBag;
    }
}

final class TestLogger extends AbstractLogger
{
    /** @var list<string> */
    public array $messages = [];

    public function log($level, $message, array $context = []): void
    {
        /** @psalm-suppress RedundantCastGivenDocblockType */
        $this->messages[] = (string) $message;
    }

    public function hasMessageMatching(string $regexp): bool
    {
        foreach ($this->messages as $message) {
            if (preg_match($regexp, $message) === 1) {
                return true;
            }
        }

        return false;
    }
}

final class NotARenderedTag
{
}
