<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag\Section;

use function Safe\usort;
use Setono\TagBag\Tag\Rendered\MultiRenderedTag;
use Setono\TagBag\Tag\Rendered\RenderedTag;
use Setono\TagBag\Tag\Rendered\RenderedTagInterface;

final class Section implements SectionInterface
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

        usort($this->tags, static function (RenderedTagInterface $tag1, RenderedTagInterface $tag2): int {
            return $tag2->getPriority() <=> $tag1->getPriority();
        });
    }

    public function hasTag(string $key): bool
    {
        return isset($this->tags[$key]);
    }

    public function count(): int
    {
        return count($this->tags);
    }
}
