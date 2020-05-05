<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag\Section;

use ArrayIterator;
use IteratorAggregate;
use function Safe\uasort;
use Setono\TagBag\Tag\Rendered\MultiRenderedTag;
use Setono\TagBag\Tag\Rendered\RenderedTag;
use Setono\TagBag\Tag\Rendered\RenderedTagInterface;

final class Section implements IteratorAggregate, SectionInterface
{
    /** @var RenderedTag[]|MultiRenderedTag[] */
    private $tags = [];

    public function addTag(RenderedTag $tag): void
    {
        if (!$tag->willReplace() && $this->hasTag($tag->getKey())) {
            $existingTag = $this->tags[$tag->getKey()];
            if ($existingTag instanceof MultiRenderedTag) {
                $existingTag->addTag($tag);
            } else {
                $this->tags[$tag->getKey()] = new MultiRenderedTag($existingTag, $tag);
            }
        } else {
            $this->tags[$tag->getKey()] = $tag;
        }

        uasort($this->tags, static function (RenderedTagInterface $tag1, RenderedTagInterface $tag2): int {
            return $tag2->getPriority() <=> $tag1->getPriority();
        });
    }

    public function __toString(): string
    {
        return implode('', $this->tags);
    }

    public function hasTag(string $key): bool
    {
        return isset($this->tags[$key]);
    }

    public function count(): int
    {
        return (int) array_sum(array_map(static function (RenderedTagInterface $tag): int {
            return count($tag);
        }, $this->tags));
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->tags);
    }
}
