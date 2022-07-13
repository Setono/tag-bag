<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\ContentAwareTag;
use Setono\TagBag\Tag\Tag;

/**
 * @covers \Setono\TagBag\Renderer\ContentAwareRenderer
 */
final class ContentAwareRendererTest extends TestCase
{
    /**
     * @test
     */
    public function it_supports_content_tag(): void
    {
        $renderer = new ContentAwareRenderer();
        self::assertTrue($renderer->supports(ContentAwareTag::create('content')));
    }

    /**
     * @test
     */
    public function it_does_not_support_other_tags(): void
    {
        $renderer = new ContentAwareRenderer();
        self::assertFalse($renderer->supports(new NotAContentAwareTag()));
    }

    /**
     * @test
     */
    public function it_renders(): void
    {
        $renderer = new ContentAwareRenderer();
        self::assertSame('content', $renderer->render(ContentAwareTag::create('content')));
    }
}

final class NotAContentAwareTag extends Tag
{
    public function __construct()
    {
        parent::__construct('setono/not-a-content-aware-tag');
    }
}
