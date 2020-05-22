<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use Setono\TagBag\Tag\StyleTagInterface;
use Setono\TagBag\Tag\TagInterface;

final class StyleRenderer extends ContentRenderer
{
    public function supports(TagInterface $tag): bool
    {
        return parent::supports($tag) && $tag instanceof StyleTagInterface;
    }

    public function render(TagInterface $tag): string
    {
        return '<style>' . parent::render($tag) . '</style>';
    }
}
