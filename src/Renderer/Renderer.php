<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use function Safe\preg_replace;

abstract class Renderer implements RendererInterface
{
    /**
     * @param string|null $wrapper The HTML tag to wrap the tags in, i.e. <script>
     */
    protected function renderWithWrapper(string $tag, ?string $wrapper): string
    {
        $str = '';

        if (null !== $wrapper) {
            $str = $wrapper;
        }

        $str .= $tag;

        if (null !== $wrapper) {
            $wrapper = '</' . mb_substr($wrapper, 1);
            $str .= preg_replace('/ [^>]+/', '', $wrapper);
        }

        return $str;
    }
}
