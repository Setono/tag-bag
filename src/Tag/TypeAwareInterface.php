<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

interface TypeAwareInterface
{
    /**
     * These are just default types, you can use your own type
     */
    public const TYPE_HTML = 'html';

    public const TYPE_SCRIPT = 'script';

    public const TYPE_STYLE = 'style';

    /**
     * Will return the type of the tag.
     */
    public function getType(): string;
}
