<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\ContentTag;
use Setono\TagBag\Tag\Tag;

/**
 * @covers \Setono\TagBag\Renderer\ContentRenderer
 */
final class ContentRendererTest extends TestCase
{
    /**
     * @test
     */
    public function it_supports_content_tag(): void
    {
        $renderer = new ContentRenderer();
        self::assertTrue($renderer->supports(new ContentTag('content')));
    }

    /**
     * @test
     */
    public function it_does_not_support_other_tags(): void
    {
        $renderer = new ContentRenderer();
        self::assertFalse($renderer->supports(new class() extends Tag {
        }));
    }

    /**
     * @test
     */
    public function it_renders(): void
    {
        $renderer = new ContentRenderer();
        self::assertSame('content', $renderer->render(new ContentTag('content')));
    }
}
