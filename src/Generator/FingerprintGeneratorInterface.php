<?php

declare(strict_types=1);

namespace Setono\TagBag\Generator;

use Setono\TagBag\Tag\TagInterface;

interface FingerprintGeneratorInterface
{
    /**
     * @param TagInterface $tag The tag to generate a fingerprint for
     * @param string $renderedValue The rendered value for the tag
     *
     * @return string The fingerprint
     */
    public function generate(TagInterface $tag, string $renderedValue): string;
}
