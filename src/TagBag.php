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
use Setono\TagBag\Tag\Rendered\RenderedTag;
use Setono\TagBag\Tag\TagInterface;
use Throwable;

final class TagBag implements TagBagInterface, LoggerAwareInterface
{
    /** @var array<string, list<RenderedTag>> */
    private array $tags = [];

    private LoggerInterface $logger;

    private FingerprintGeneratorInterface $fingerprintGenerator;

    private ?StorageInterface $storage = null;

    private ?EventDispatcherInterface $eventDispatcher = null;

    private RendererInterface $renderer;

    public function __construct(RendererInterface $renderer, FingerprintGeneratorInterface $fingerprintGenerator = null)
    {
        $this->logger = new NullLogger();
        $this->fingerprintGenerator = $fingerprintGenerator ?? new ValueBasedFingerprintGenerator();
        $this->renderer = $renderer;
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
            $existingTag = $this->findTagByFingerprint($fingerprint);
            if (null !== $existingTag && ($existingTag->isUnique() || $tag->isUnique())) {
                return;
            }

            $renderedTag = RenderedTag::createFromTag($tag, $renderedValue, $fingerprint);
            $this->tags[$renderedTag->getSection()][] = $renderedTag;

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
            $str .= $tag->getValue();
        }

        return $str;
    }

    /**
     * @param list<RenderedTag> $tags
     */
    private static function sort(array &$tags): void
    {
        usort($tags, static function (RenderedTag $tag1, RenderedTag $tag2): int {
            return $tag2->getPriority() <=> $tag1->getPriority();
        });
    }

    public function store(): void
    {
        if (null === $this->storage) {
            $this->logger->error('You are trying to store the tag bag, but haven\t set any storage');

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
            $this->logger->error('You are trying to restore the tag bag, but haven\t set any storage');

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
            $this->tags = unserialize($data, ['allowed_classes' => [
                RenderedTag::class,
            ]]);
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

    private function findTagByFingerprint(string $fingerprint): ?RenderedTag
    {
        foreach ($this->tags as $section) {
            foreach ($section as $tag) {
                if ($tag->getFingerprint() === $fingerprint) {
                    return $tag;
                }
            }
        }

        return null;
    }
}
