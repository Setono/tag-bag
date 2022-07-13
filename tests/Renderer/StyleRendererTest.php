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
        self::assertTrue($renderer->supports(StyleTag::create('content')));
    }

    /**
     * @test
     */
    public function it_does_not_support_other_tags(): void
    {
        $renderer = new StyleRenderer();
        self::assertFalse($renderer->supports(new NotAStyleTag()));
    }

    /**
     * @test
     */
    public function it_renders(): void
    {
        $renderer = new StyleRenderer();
        self::assertSame('<style>content</style>', $renderer->render(StyleTag::create('content')));
    }

    /**
     * @test
     */
    public function it_renders_with_single_attribute(): void
    {
        $tag = StyleTag::create('content')
            ->withAttribute('data-attribute')
        ;

        $renderer = new StyleRenderer();
        self::assertSame('<style data-attribute>content</style>', $renderer->render($tag));
    }

    /**
     * @test
     */
    public function it_renders_with_single_attribute_and_value(): void
    {
        $tag = StyleTag::create('content')
            ->withAttribute('data-attribute', 'attribute-value')
        ;

        $renderer = new StyleRenderer();
        self::assertSame('<style data-attribute="attribute-value">content</style>', $renderer->render($tag));
    }

    /**
     * @test
     */
    public function it_renders_with_multiple_attributes(): void
    {
        $tag = StyleTag::create('content')
            ->withAttribute('data-attribute1')
            ->withAttribute('data-attribute2', 'attribute2-value')
        ;

        $renderer = new StyleRenderer();
        self::assertSame('<style data-attribute1 data-attribute2="attribute2-value">content</style>', $renderer->render($tag));
    }
}

final class NotAStyleTag extends Tag
{
    public function __construct()
    {
        parent::__construct('setono/not-a-style-tag');
    }
}
