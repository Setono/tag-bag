<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

/**
 * The inline script tag represents script tags in the form of <script>function foobar() {}</script>
 */
final class ScriptTag extends ElementTag
{
    /**
     * @return static
     */
    public static function create(string $src, string $name = null): self
    {
        return parent::createWithoutContent('script', true, $name ?? 'setono/script-tag')
            ->withSrc($src)
        ;
    }

    /**
     * Returns the src attribute value for the <script src="..."> tag
     */
    public function getSrc(): ?string
    {
        return $this->attributes['src'] ?? null;
    }

    /**
     * @return static
     */
    public function withSrc(string $src): self
    {
        return $this->withAttribute('src', $src);
    }

    /**
     * Returns the type attribute for the <script type="..."> tag
     */
    public function getType(): ?string
    {
        return $this->attributes['type'] ?? null;
    }

    /**
     * @return static
     */
    public function withType(string $type): self
    {
        return $this->withAttribute('type', $type);
    }

    public function isDeferred(): bool
    {
        return array_key_exists('defer', $this->attributes);
    }

    /**
     * @return static
     */
    public function defer(): self
    {
        return $this->withAttribute('defer');
    }

    public function isAsync(): bool
    {
        return array_key_exists('async', $this->attributes);
    }

    /**
     * @return static
     */
    public function async(): self
    {
        return $this->withAttribute('async');
    }
}
