<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use Laminas\Stdlib\FastPriorityQueue;
use Setono\TagBag\Exception\UnsupportedTagException;
use Setono\TagBag\Tag\TagInterface;

final class CompositeRenderer implements RendererInterface
{
    /**
     * @var FastPriorityQueue|RendererInterface[]
     *
     * @psalm-var FastPriorityQueue
     */
    private FastPriorityQueue $renderers;

    public function __construct()
    {
        $this->renderers = new FastPriorityQueue();
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
