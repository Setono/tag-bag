<?php

declare(strict_types=1);

namespace Setono\TagBag;

use function Safe\usort;
use Setono\TagBag\Exception\NonExistingTagsException;
use Setono\TagBag\Exception\UnsupportedTagException;
use Setono\TagBag\Renderer\RendererInterface;
use Setono\TagBag\Storage\StorageInterface;
use Setono\TagBag\Tag\Rendered\RenderedTag;
use Setono\TagBag\Tag\TagInterface;

final class TagBag implements TagBagInterface
{
    /** @var RenderedTag[][] */
    private $tags = [];

    /** @var RendererInterface */
    private $renderer;

    /** @var StorageInterface */
    private $storage;

    public function __construct(RendererInterface $renderer, StorageInterface $storage)
    {
        $this->renderer = $renderer;
        $this->storage = $storage;
    }

    public function addTag(TagInterface $tag): TagBagInterface
    {
        if (!$this->renderer->supports($tag)) {
            throw new UnsupportedTagException($tag);
        }

        if (count($tag->getDependencies()) > 0) {
            $nonExistingTags = $this->nonExistingTags($tag->getDependencies());

            if (count($nonExistingTags) > 0) {
                throw new NonExistingTagsException($nonExistingTags);
            }
        }

        $section = $tag->getSection() ?? self::DEFAULT_SECTION;

        $this->tags[$section][] = new RenderedTag(
            $tag->getName(), $this->renderer->render($tag), $tag->getPriority()
        );

        usort($this->tags[$section], static function (RenderedTag $tag1, RenderedTag $tag2): int {
            return $tag2->getPriority() <=> $tag1->getPriority();
        });

        return $this;
    }

    public function getAll(): array
    {
        return $this->tags;
    }

    public function getSection(string $section): ?array
    {
        return $this->tags[$section] ?? null;
    }

    public function renderAll(): string
    {
        $tags = $this->tags;
        $this->tags = [];

        return implode('', array_map(static function (array $section): string {
            return implode('', $section);
        }, $tags));
    }

    public function renderSection(string $section): string
    {
        $tags = $this->tags[$section] ?? [];
        unset($this->tags[$section]);

        return implode('', $tags);
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
     * Returns an array of non existing tags in the tag bag (not minding the section)
     *
     * Returns an empty array if all tags exist
     */
    private function nonExistingTags(array $keys): array
    {
        $nonExistingKeys = [];

        foreach ($keys as $key) {
            $keyExists = false;

            foreach ($this->tags as $section) {
                foreach ($section as $tag) {
                    if ($tag->getName() === $key) {
                        $keyExists = true;
                    }
                }
            }

            if (!$keyExists) {
                $nonExistingKeys[] = $key;
            }
        }

        return $nonExistingKeys;
    }
}
