<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

/**
 * The inline script tag represents script tags in the form of <script>function foobar() {}</script>.
 * If you need a <script src="..."></script> tag, @see ScriptTag
 */
final class InlineScriptTag extends ElementTag
{
    /**
     * @return static
     */
    public static function create(string $content, string $name = null): self
    {
        return parent::createWithContent('script', $content, $name ?? 'setono/inline-script-tag');
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
}
