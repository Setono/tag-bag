<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag\Rendered;

use function Safe\usort;

/**
 * @internal
 */
final class MultiRenderedTag implements RenderedTagInterface
{
    /** @var RenderedTag[] */
    private $tags = [];

    /** @var int */
    private $priority = 0;

    public function __construct(RenderedTag ...$tags)
    {
        foreach ($tags as $tag) {
            $this->addTag($tag);
        }
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    public function addTag(RenderedTag $tag): void
    {
        $this->tags[] = $tag;

        usort($this->tags, static function (RenderedTagInterface $tag1, RenderedTagInterface $tag2): int {
            return $tag2->getPriority() <=> $tag1->getPriority();
        });

        // we set the priority of this 'multi tag' to the highest priority of all tags
        $this->priority = $this->tags[0]->getPriority();
    }

    public function getValue(): string
    {
        return implode('', $this->tags);
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @return RenderedTag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    public function count(): int
    {
        return count($this->tags);
    }
}
