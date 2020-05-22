<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use function Safe\sprintf;
use Setono\TagBag\Tag\ScriptTagInterface;
use Setono\TagBag\Tag\TagInterface;

final class ScriptRenderer extends ContentRenderer
{
    public function supports(TagInterface $tag): bool
    {
        return parent::supports($tag) && $tag instanceof ScriptTagInterface;
    }

    /**
     * @param TagInterface|ScriptTagInterface $tag
     */
    public function render(TagInterface $tag): string
    {
        $type = $tag->getType() === null ? '' : sprintf(' type="%s"', $tag->getType());

        return sprintf('<script%s>%s</script>', $type, parent::render($tag));
    }
}
