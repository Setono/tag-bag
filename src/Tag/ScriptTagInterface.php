<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

interface ScriptTagInterface extends TagInterface, ContentAwareInterface
{
    /**
     * Returns the type attribute for the <script type="..."> tag
     *
     * If this method returns null, the resulting script tag should be rendered as <script>
     */
    public function getType(): ?string;
}
