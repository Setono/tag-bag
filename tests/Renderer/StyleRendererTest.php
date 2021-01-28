<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\StyleTag;
use Setono\TagBag\Tag\Tag;

/**
 * @covers \Setono\TagBag\Renderer\StyleRenderer
 */
final class StyleRendererTest extends TestCase
{
    /**
     * @test
     */
    public function it_supports_style_tag(): void
    {
        $renderer = new StyleRenderer();
        self::assertTrue($renderer->supports(new StyleTag('content')));
    }

    /**
     * @test
     */
    public function it_does_not_support_other_tags(): void
    {
        $renderer = new StyleRenderer();
        self::assertFalse($renderer->supports(new class() extends Tag {
        }));
    }

    /**
     * @test
     */
    public function it_renders(): void
    {
        $renderer = new StyleRenderer();
        self::assertSame('<style>content</style>', $renderer->render(new StyleTag('content')));
    }
}
