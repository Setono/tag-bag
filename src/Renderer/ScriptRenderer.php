<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use Setono\TagBag\Tag\TagInterface;
use Setono\TagBag\Tag\TypeAwareInterface;

final class ScriptRenderer implements RendererInterface
{
    /** @var RendererInterface */
    private $decoratedRenderer;

    public function __construct(RendererInterface $decoratedRenderer)
    {
        $this->decoratedRenderer = $decoratedRenderer;
    }

    public function supports(TagInterface $tag): bool
    {
        return $this->decoratedRenderer->supports($tag) && $tag instanceof TypeAwareInterface && $tag->getType() === TypeAwareInterface::TYPE_SCRIPT;
    }

    public function render(TagInterface $tag): string
    {
        return '<script>' . $this->decoratedRenderer->render($tag) . '</script>';
    }
}
