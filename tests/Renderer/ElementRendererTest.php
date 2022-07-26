<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\InlineScriptTag;
use Setono\TagBag\Tag\LinkTag;
use Setono\TagBag\Tag\Tag;
use Setono\TagBag\Tag\TagInterface;

/**
 * @covers \Setono\TagBag\Renderer\ElementRenderer
 */
final class ElementRendererTest extends TestCase
{
    /**
     * @test
     */
    public function it_supports_element_tag(): void
    {
        self::assertTrue((new ElementRenderer())->supports(InlineScriptTag::create('content')));
    }

    /**
     * @test
     */
    public function it_does_not_support_other_tags(): void
    {
        self::assertFalse((new ElementRenderer())->supports(new NotAnElementTag()));
    }

    /**
     * @test
     */
    public function it_renders(): void
    {
        self::assertRenderedContent('<script>content</script>', InlineScriptTag::create('content'));
    }

    /**
     * @test
     */
    public function it_renders_with_type(): void
    {
        self::assertRenderedContent(
            '<script type="application/ld+json">content</script>',
            InlineScriptTag::create('content')->withType('application/ld+json')
        );
    }

    /**
     * @test
     */
    public function it_renders_with_single_attribute(): void
    {
        self::assertRenderedContent(
            '<script data-attribute>content</script>',
            InlineScriptTag::create('content')
                ->withAttribute('data-attribute')
        );
    }

    /**
     * @test
     */
    public function it_renders_with_single_attribute_and_value(): void
    {
        self::assertRenderedContent(
            '<script data-attribute="attribute-value">content</script>',
            InlineScriptTag::create('content')
                ->withAttribute('data-attribute', 'attribute-value')
        );
    }

    /**
     * @test
     */
    public function it_renders_with_multiple_attributes(): void
    {
        self::assertRenderedContent(
            '<script type="application/ld+json" data-attribute1 data-attribute2="attribute2-value">content</script>',
            InlineScriptTag::create('content')
                ->withType('application/ld+json')
                ->withAttribute('data-attribute1')
                ->withAttribute('data-attribute2', 'attribute2-value')
        );
    }

    /**
     * @test
     */
    public function it_renders_tags_with_no_closing_element(): void
    {
        self::assertRenderedContent(
            '<link rel="stylesheet" href="https://example.com/style.css">',
            LinkTag::create('stylesheet', 'https://example.com/style.css')
        );
    }

    private static function assertRenderedContent(string $expected, TagInterface $tag): void
    {
        self::assertSame($expected, (new ElementRenderer())->render($tag));
    }
}

final class NotAnElementTag extends Tag
{
}
