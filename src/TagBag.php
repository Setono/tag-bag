<?php

declare(strict_types=1);

namespace Setono\TagBag;

use InvalidArgumentException;
use Psr\EventDispatcher\EventDispatcherInterface;
use function Safe\sprintf;
use function Safe\usort;
use Setono\TagBag\Event\PostAddEvent;
use Setono\TagBag\Event\PreAddEvent;
use Setono\TagBag\Exception\NonExistingTagsException;
use Setono\TagBag\Exception\UnsupportedTagException;
use Setono\TagBag\Generator\FingerprintGeneratorInterface;
use Setono\TagBag\Renderer\RendererInterface;
use Setono\TagBag\Storage\StorageInterface;
use Setono\TagBag\Tag\Rendered\RenderedTag;
use Setono\TagBag\Tag\TagInterface;

final class TagBag implements TagBagInterface
{
    /** @var RenderedTag[][] */
    private $tags = [];

    /**
     * This holds an array of tag names already rendered in the life of this tag bag
     *
     * @var string[]
     */
    private $renderedTags = [];

    /** @var RendererInterface */
    private $renderer;

    /** @var StorageInterface */
    private $storage;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /** @var FingerprintGeneratorInterface */
    private $fingerprintGenerator;

    public function __construct(
        RendererInterface $renderer,
        StorageInterface $storage,
        EventDispatcherInterface $eventDispatcher,
        FingerprintGeneratorInterface $fingerprintGenerator
    ) {
        $this->renderer = $renderer;
        $this->storage = $storage;
        $this->eventDispatcher = $eventDispatcher;
        $this->fingerprintGenerator = $fingerprintGenerator;
    }

    public function addTag(TagInterface $tag): TagBagInterface
    {
        $this->eventDispatcher->dispatch(new PreAddEvent($tag));

        if (!$this->renderer->supports($tag)) {
            throw new UnsupportedTagException($tag);
        }

        $renderedValue = $this->renderer->render($tag);
        $fingerprint = $this->fingerprintGenerator->generate($tag, $renderedValue);
        $existingTag = $this->findTagByFingerprint($fingerprint);
        if (null !== $existingTag && ($existingTag->isUnique() || $tag->isUnique())) {
            return $this;
        }

        $renderedTag = RenderedTag::createFromTag($tag, $renderedValue, $fingerprint);
        $this->tags[$tag->getSection()][] = $renderedTag;

        usort($this->tags[$tag->getSection()], static function (RenderedTag $tag1, RenderedTag $tag2): int {
            return $tag2->getPriority() <=> $tag1->getPriority();
        });

        $this->eventDispatcher->dispatch(new PostAddEvent($renderedTag, $this));

        return $this;
    }

    public function getAll(): array
    {
        return $this->tags;
    }

    public function getSection(string $section): array
    {
        if (!$this->hasSection($section)) {
            throw new InvalidArgumentException(sprintf('The section, "%s", does not exist', $section));
        }

        return $this->tags[$section];
    }

    public function hasSection(string $section): bool
    {
        return isset($this->tags[$section]);
    }

    public function getTag(string $name): RenderedTag
    {
        foreach ($this->tags as $section) {
            foreach ($section as $tag) {
                if ($tag->getName() === $name) {
                    return $tag;
                }
            }
        }

        throw new InvalidArgumentException(sprintf('The tag, "%s", does not exist', $name));
    }

    public function hasTag(string $name): bool
    {
        foreach ($this->tags as $section) {
            foreach ($section as $tag) {
                if ($tag->getName() === $name) {
                    return true;
                }
            }
        }

        return false;
    }

    public function renderAll(): string
    {
        $this->assertDependencies($this->tags);

        $tags = $this->tags;
        $this->tags = [];

        $str = '';
        foreach ($tags as $section) {
            foreach ($section as $tag) {
                $this->renderedTags[] = $tag->getName();
                $str .= $tag->getValue();
            }
        }

        return $str;
    }

    public function renderSection(string $section): string
    {
        if (!$this->hasSection($section)) {
            return '';
        }

        $tags = $this->getSection($section);
        $this->assertDependencies([$tags]);
        unset($this->tags[$section]);

        $str = '';
        foreach ($tags as $tag) {
            $this->renderedTags[] = $tag->getName();
            $str .= $tag->getValue();
        }

        return $str;
    }

    public function store(): void
    {
        if (count($this->tags) === 0) {
            $this->storage->remove();
        } else {
            $this->storage->store(serialize($this->tags));
        }
    }

    public function restore(): void
    {
        $data = $this->storage->restore();

        $this->tags = [];
        if (null !== $data) {
            $this->tags = unserialize($data, ['allowed_classes' => true]);
        }
    }

    /**
     * Returns the total number of tags
     */
    public function count(): int
    {
        if (count($this->tags) === 0) {
            return 0;
        }

        return (int) array_sum(array_map(static function (array $section): int {
            return count($section);
        }, $this->tags));
    }

    /**
     * @param RenderedTag[][] $tags
     */
    private function assertDependencies(array $tags): void
    {
        $nonExistingTags = [];

        foreach ($tags as $section) {
            foreach ($section as $tag) {
                foreach ($tag->getDependencies() as $dependency) {
                    // we first check the already rendered tags
                    foreach ($this->renderedTags as $renderedTagName) {
                        if ($renderedTagName === $dependency) {
                            continue 2;
                        }
                    }

                    // ... and then the to-be-rendered tags
                    foreach ($this->tags as $section2) {
                        foreach ($section2 as $renderedTag) {
                            if ($renderedTag->getName() === $dependency) {
                                continue 3;
                            }
                        }
                    }

                    $nonExistingTags[] = $dependency;
                }
            }
        }

        if (count($nonExistingTags) > 0) {
            throw new NonExistingTagsException($nonExistingTags);
        }
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
