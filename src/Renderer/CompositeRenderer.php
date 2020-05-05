<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use Setono\TagBag\Exception\UnsupportedTagException;
use Setono\TagBag\Tag\TagInterface;

final class CompositeRenderer implements RendererInterface
{
    /** @var RendererInterface[] */
    private $renderers;

    public function __construct(RendererInterface ...$renderers)
    {
        $this->renderers = $renderers;
    }

    public function supports(TagInterface $tag): bool
    {
        foreach ($this->renderers as $renderer) {
            if ($renderer->supports($tag)) {
                return true;
            }
        }

        return false;
    }

    public function render(TagInterface $tag): string
    {
        foreach ($this->renderers as $renderer) {
            if ($renderer->supports($tag)) {
                return $renderer->render($tag);
            }
        }

        throw new UnsupportedTagException($tag);
    }
}
