<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use Setono\TagBag\Exception\UnsupportedTagException;
use Setono\TagBag\Tag\TagInterface;
use SplPriorityQueue;

final class CompositeRenderer implements RendererInterface
{
    /** @var SplPriorityQueue|RendererInterface[] */
    private $renderers;

    public function __construct()
    {
        $this->renderers = new SplPriorityQueue();
    }

    public function addRenderer(RendererInterface $renderer, int $priority = 0): void
    {
        $this->renderers->insert($renderer, $priority);
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
