<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag\Rendered;

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
        return implode('', $this->tags);
    }

    public function addTag(RenderedTag $tag): void
    {
        $this->tags[] = $tag;

        // We use the highest priority as the aggregate priority
        $priority = $tag->getPriority();
        foreach ($this->tags as $item) {
            if ($item->getPriority() > $priority) {
                $priority = $item->getPriority();
            }
        }

        $this->priority = $priority;
    }

    /**
     * @return RenderedTag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }
}
