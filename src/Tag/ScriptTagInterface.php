<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

interface ScriptTagInterface extends TagInterface, ContentAwareTagInterface
{
    /**
     * Returns the type attribute for the <script type="..."> tag
     */
    public function getType(): ?string;

    /**
     * @return array<string, string|null>
     */
    public function getAttributes(): array;
}
