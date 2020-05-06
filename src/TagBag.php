<?php

declare(strict_types=1);

namespace Setono\TagBag;

use function Safe\sprintf;
use Setono\TagBag\Exception\NonExistingTagsException;
use Setono\TagBag\Renderer\RendererInterface;
use Setono\TagBag\Storage\StorageInterface;
use Setono\TagBag\Tag\Rendered\RenderedTag;
use Setono\TagBag\Tag\Section\Section;
use Setono\TagBag\Tag\Section\SectionInterface;
use Setono\TagBag\Tag\TagInterface;
use Webmozart\Assert\Assert;

final class TagBag implements TagBagInterface
{
    public const UNSET_SECTION_KEY = '__unset__';

    /** @var SectionInterface[] */
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
        Assert::true($this->renderer->supports($tag), sprintf('The tag %s is not supported by the given tag renderer', get_class($tag)));

        if (count($tag->getDependents()) > 0) {
            $nonExistingKeys = $this->nonExistingKeys($tag->getDependents());

            if (count($nonExistingKeys) > 0) {
                throw new NonExistingTagsException($nonExistingKeys);
            }
        }

        $section = $tag->getSection() ?? self::UNSET_SECTION_KEY;

        if (!$this->hasSection($section)) {
            $this->tags[$section] = new Section();
        }

        $this->tags[$section]->addTag(new RenderedTag(
            $tag->getKey(), $this->renderer->render($tag), $tag->getPriority(), $tag->willReplace()
        ));

        return $this;
    }

    public function getAll(): array
    {
        $tags = $this->tags;
        $this->tags = [];

        return $tags;
    }

    public function getSection(string $section): ?SectionInterface
    {
        if (!$this->hasSection($section)) {
            return null;
        }

        $tags = $this->tags[$section];
        unset($this->tags[$section]);

        return $tags;
    }

    public function store(): void
    {
        if (count($this->tags) === 0) {
            return;
        }

        $this->storage->store(serialize($this->tags));
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

        return (int) array_sum(array_map(static function (SectionInterface $section): int {
            return count($section);
        }, $this->tags));
    }

    private function hasSection(string $section): bool
    {
        return array_key_exists($section, $this->tags) && count($this->tags[$section]) > 0;
    }

    /**
     * Returns an array of non existing keys in the tag bag (not minding the section)
     *
     * Returns an empty array if all keys exist
     */
    private function nonExistingKeys(array $keys): array
    {
        $nonExistingKeys = [];

        foreach ($keys as $key) {
            $keyExists = false;

            foreach ($this->tags as $section) {
                if ($section->hasTag($key)) {
                    $keyExists = true;
                }
            }

            if (!$keyExists) {
                $nonExistingKeys[] = $key;
            }
        }

        return $nonExistingKeys;
    }
}
