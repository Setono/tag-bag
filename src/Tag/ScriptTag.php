<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

final class ScriptTag extends ContentAwareTag implements ScriptTagInterface
{
    private ?string $type = null;

    /**
     * @return static
     */
    public static function create(string $content, string $name = null): self
    {
        return parent::create($content, $name ?? 'setono/script-tag');
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return static
     */
    public function withType(string $type): self
    {
        $obj = clone $this;
        $obj->type = $type;

        return $obj;
    }
}
