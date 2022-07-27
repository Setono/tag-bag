<?php

declare(strict_types=1);

namespace Setono\TagBag;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Setono\TagBag\Event\PreTagAddedEvent;
use Setono\TagBag\Event\TagAddedEvent;
use Setono\TagBag\Exception\StorageException;
use Setono\TagBag\Exception\UnsupportedTagException;
use Setono\TagBag\Generator\FingerprintGeneratorInterface;
use Setono\TagBag\Generator\ValueBasedFingerprintGenerator;
use Setono\TagBag\Renderer\RendererInterface;
use Setono\TagBag\Storage\StorageInterface;
use Setono\TagBag\Tag\RenderedTag;
use Setono\TagBag\Tag\TagInterface;
use Throwable;

final class TagBag implements TagBagInterface, LoggerAwareInterface
{
    /** @var array<string, list<RenderedTag>> */
    private array $tags = [];

    private LoggerInterface $logger;

    private ?StorageInterface $storage = null;

    private ?EventDispatcherInterface $eventDispatcher = null;

    private RendererInterface $renderer;

    private FingerprintGeneratorInterface $fingerprintGenerator;

    public function __construct(RendererInterface $renderer, FingerprintGeneratorInterface $fingerprintGenerator = null)
    {
        $this->logger = new NullLogger();
        $this->renderer = $renderer;
        $this->fingerprintGenerator = $fingerprintGenerator ?? new ValueBasedFingerprintGenerator();
    }

    public function add(TagInterface $tag): void
    {
        $this->dispatch(new PreTagAddedEvent($tag));

        if (!$this->renderer->supports($tag)) {
            throw new UnsupportedTagException($tag);
        }

        try {
            $renderedValue = $this->renderer->render($tag);
            $fingerprint = $tag->getFingerprint() ?? $this->fingerprintGenerator->generate($tag, $renderedValue);

            if (!$this->handleExistingTag($tag, $fingerprint)) {
                return;
            }

            $renderedTag = RenderedTag::createFromTag($tag, $renderedValue, $fingerprint);
            $this->tags[$renderedTag->section][] = $renderedTag;

            $this->dispatch(new TagAddedEvent($renderedTag, $this));
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
        }
    }

    public function renderAll(): string
    {
        $tags = $this->tags;
        $this->tags = [];

        $str = '';
        foreach ($tags as $section) {
            $str .= self::renderTags($section);
        }

        return $str;
    }

    public function renderSection(string $section): string
    {
        $value = self::renderTags($this->tags[$section] ?? []);

        unset($this->tags[$section]);

        return $value;
    }

    /**
     * Returns true if the tag should be added
     */
    private function handleExistingTag(TagInterface $tag, string $fingerprint): bool
    {
        $search = $this->findTagByFingerprint($fingerprint);

        // if no existing tag exists we should add the tag
        if (null === $search) {
            return true;
        }

        [$section, $idx, $existingTag] = $search;

        // if both tags are unique
        if ($existingTag->unique && $tag->isUnique()) {
            // ... we check the priority and if the priority of the new tag is higher than the existing tag
            if ($existingTag->priority >= $tag->getPriority()) {
                return false;
            }

            // ... we will remove the old tag and add the new tag
            unset($this->tags[$section][$idx]);

            return true;
        }

        // if the old tag is unique, but the new tag isn't, we will not add the new tag
        if ($existingTag->unique) {
            return false;
        }

        // if the old tag is not unique, but the new tag is, we will remove the old tag and add the new tag
        if ($tag->isUnique()) {
            unset($this->tags[$section][$idx]);
        }

        return true;
    }

    /**
     * @param list<RenderedTag> $tags
     */
    private static function renderTags(array $tags): string
    {
        if ([] === $tags) {
            return '';
        }

        self::sort($tags);

        $str = '';
        foreach ($tags as $tag) {
            $str .= $tag->value;
        }

        return $str;
    }

    /**
     * @param list<RenderedTag> $tags
     */
    private static function sort(array &$tags): void
    {
        usort($tags, static function (RenderedTag $tag1, RenderedTag $tag2): int {
            return $tag2->priority <=> $tag1->priority;
        });
    }

    public function store(): void
    {
        if (null === $this->storage) {
            $this->logger->error('You are trying to store the tag bag, but haven\'t set any storage');

            return;
        }

        try {
            if (count($this->tags) === 0) {
                $this->storage->remove();
            } else {
                $this->storage->store(serialize($this->tags));
            }
        } catch (StorageException $e) {
            $this->logger->error($e->getMessage());
        }
    }

    public function restore(): void
    {
        if (null === $this->storage) {
            $this->logger->error('You are trying to restore the tag bag, but haven\'t set any storage');

            return;
        }

        try {
            $data = $this->storage->restore();
        } catch (StorageException $e) {
            $this->logger->error($e->getMessage());

            return;
        }

        $this->tags = [];
        if (null !== $data) {
            $this->tags = $this->unserialize($data);
        }
    }

    public function setStorage(StorageInterface $storage): void
    {
        $this->storage = $storage;
    }

    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    private function dispatch(object $event): void
    {
        if (null === $this->eventDispatcher) {
            return;
        }

        $this->eventDispatcher->dispatch($event);
    }

    /**
     * @return array{0: string, 1: int, 2: RenderedTag}|null
     */
    private function findTagByFingerprint(string $fingerprint): ?array
    {
        foreach ($this->tags as $section => $sectionTags) {
            foreach ($sectionTags as $idx => $tag) {
                if ($tag->fingerprint === $fingerprint) {
                    return [$section, $idx, $tag];
                }
            }
        }

        return null;
    }

    /**
     * @psalm-suppress MixedInferredReturnType
     *
     * @return array<string, list<RenderedTag>>
     */
    private function unserialize(string $data): array
    {
        /** @psalm-suppress MixedReturnStatement */
        return unserialize($data, ['allowed_classes' => [
            RenderedTag::class,
        ]]);
    }
}
