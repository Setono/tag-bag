<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

final class LinkTag extends ElementTag
{
    /**
     * @return static
     */
    public static function create(string $rel = null, string $href = null): self
    {
        $tag = parent::createWithoutContent('link', false);

        if (null !== $rel) {
            $tag = $tag->withRel($rel);
        }

        if (null !== $href) {
            $tag = $tag->withHref($href);
        }

        return $tag;
    }

    public function getRel(): ?string
    {
        return $this->attributes['rel'] ?? null;
    }

    /**
     * @return static
     */
    public function withRel(string $rel): self
    {
        return $this->withAttribute('rel', $rel);
    }

    public function getHref(): ?string
    {
        return $this->attributes['href'] ?? null;
    }

    /**
     * @return static
     */
    public function withHref(string $href): self
    {
        return $this->withAttribute('href', $href);
    }
}
