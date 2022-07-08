<?php

declare(strict_types=1);

namespace Setono\TagBag;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Setono\TagBag\Event\PreTagAddedEvent;
use Setono\TagBag\Event\TagAddedEvent;
use Setono\TagBag\Exception\UnsupportedTagException;
use Setono\TagBag\Generator\FingerprintGeneratorInterface;
use Setono\TagBag\Generator\ValueBasedFingerprintGenerator;
use Setono\TagBag\Renderer\RendererInterface;
use Setono\TagBag\Storage\StorageInterface;
use Setono\TagBag\Tag\Rendered\RenderedTag;
use Setono\TagBag\Tag\TagInterface;

final class TagBag implements TagBagInterface, LoggerAwareInterface
{
    /** @var array<string, list<RenderedTag>> */
    private array $tags = [];

    private LoggerInterface $logger;

    private FingerprintGeneratorInterface $fingerprintGenerator;

    private ?StorageInterface $storage = null;

    private ?EventDispatcherInterface $eventDispatcher = null;

    private RendererInterface $renderer;

    public function __construct(RendererInterface $renderer)
    {
        $this->logger = new NullLogger();
        $this->fingerprintGenerator = new ValueBasedFingerprintGenerator();
        $this->renderer = $renderer;
    }

    public function add(TagInterface $tag): void
    {
        $this->dispatch(new PreTagAddedEvent($tag));

        if (!$this->renderer->supports($tag)) {
            throw new UnsupportedTagException($tag);
        }

        $renderedValue = $this->renderer->render($tag);
        $fingerprint = $this->getFingerprint($tag, $renderedValue);
        $existingTag = $this->findTagByFingerprint($fingerprint);
        if (null !== $existingTag && ($existingTag->isUnique() || $tag->isUnique())) {
            return;
        }

        $renderedTag = RenderedTag::createFromTag($tag, $renderedValue, $fingerprint);
        $this->tags[$renderedTag->getSection()][] = $renderedTag;

        $this->dispatch(new TagAddedEvent($renderedTag, $this));
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

        if (count($this->tags) === 0) {
            $this->storage->remove();
        } else {
            $this->storage->store(serialize($this->tags));
        }
    }

    public function restore(): void
    {
        if (null === $this->storage) {
            $this->logger->error('You are trying to restore the tag bag, but haven\t set any storage');

            return;
        }

        $data = $this->storage->restore();

        $this->tags = [];
        if (null !== $data) {
            $this->tags = unserialize($data, ['allowed_classes' => true]);
        }
    }

    public function dispatch(object $event): void
    {
        if (null === $this->eventDispatcher) {
            return;
        }

        $this->eventDispatcher->dispatch($event);
    }

    public function setFingerprintGenerator(FingerprintGeneratorInterface $fingerprintGenerator): void
    {
        $this->fingerprintGenerator = $fingerprintGenerator;
    }

    public function setStorage(StorageInterface $storage): void
    {
        $this->storage = $storage;
    }

    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    private function getFingerprint(TagInterface $tag, string $renderedValue): string
    {
        return $tag->getFingerprint() ?? $this->fingerprintGenerator->generate($tag, $renderedValue);
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

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}
