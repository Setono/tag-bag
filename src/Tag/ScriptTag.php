<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

final class ScriptTag extends ContentAwareTag implements AttributesAwareInterface
{
    use AttributesAwareTrait;

    /**
     * @return static
     */
    public static function create(string $content, string $name = null): self
    {
        return parent::create($content, $name ?? 'setono/script-tag');
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
