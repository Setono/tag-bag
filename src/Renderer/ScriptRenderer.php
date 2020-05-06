<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use Setono\TagBag\Tag\TagInterface;
use Setono\TagBag\Tag\TypeAwareInterface;

final class ScriptRenderer extends ContentRenderer
{
    public function supports(TagInterface $tag): bool
    {
        return parent::supports($tag) && $tag instanceof TypeAwareInterface && $tag->getType() === TypeAwareInterface::TYPE_SCRIPT;
    }

    public function render(TagInterface $tag): string
    {
        return '<script>' . parent::render($tag) . '</script>';
    }
}
