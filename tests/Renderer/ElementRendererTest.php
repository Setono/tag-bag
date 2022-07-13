<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\InlineScriptTag;
use Setono\TagBag\Tag\Tag;

/**
 * @covers \Setono\TagBag\Renderer\ElementRenderer
 */
final class ElementRendererTest extends TestCase
{
    /**
     * @test
     */
    public function it_supports_script_tag(): void
    {
        $renderer = new ElementRenderer();
        self::assertTrue($renderer->supports(InlineScriptTag::create('content')));
    }

    /**
     * @test
     */
    public function it_does_not_support_other_tags(): void
    {
        $renderer = new ElementRenderer();
        self::assertFalse($renderer->supports(new NotAScriptTag()));
    }

    /**
     * @test
     */
    public function it_renders(): void
    {
        $renderer = new ElementRenderer();
        self::assertSame('<script>content</script>', $renderer->render(InlineScriptTag::create('content')));
    }

    /**
     * @test
     */
    public function it_renders_with_type(): void
    {
        $tag = InlineScriptTag::create('content')->withType('application/ld+json');

        $renderer = new ElementRenderer();
        self::assertSame('<script type="application/ld+json">content</script>', $renderer->render($tag));
    }

    /**
     * @test
     */
    public function it_renders_with_single_attribute(): void
    {
        $tag = InlineScriptTag::create('content')
            ->withAttribute('data-attribute')
        ;

        $renderer = new ElementRenderer();
        self::assertSame('<script data-attribute>content</script>', $renderer->render($tag));
    }

    /**
     * @test
     */
    public function it_renders_with_single_attribute_and_value(): void
    {
        $tag = InlineScriptTag::create('content')
            ->withAttribute('data-attribute', 'attribute-value')
        ;

        $renderer = new ElementRenderer();
        self::assertSame('<script data-attribute="attribute-value">content</script>', $renderer->render($tag));
    }

    /**
     * @test
     */
    public function it_renders_with_multiple_attributes(): void
    {
        $tag = InlineScriptTag::create('content')
            ->withType('application/ld+json')
            ->withAttribute('data-attribute1')
            ->withAttribute('data-attribute2', 'attribute2-value')
        ;

        $renderer = new ElementRenderer();
        self::assertSame('<script type="application/ld+json" data-attribute1 data-attribute2="attribute2-value">content</script>', $renderer->render($tag));
    }
}

final class NotAScriptTag extends Tag
{
    public function __construct()
    {
        parent::__construct('setono/not-a-script-tag');
    }
}
