<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Exception\UnsupportedTagException;
use Setono\TagBag\Tag\InlineScriptTag;
use Setono\TagBag\Tag\StyleTag;
use Setono\TagBag\Tag\Tag;

/**
 * @covers \Setono\TagBag\Renderer\CompositeRenderer
 */
final class CompositeRendererTest extends TestCase
{
    /**
     * @test
     */
    public function it_supports_multiple_tags(): void
    {
        $renderer = self::getCompositeRenderer();

        self::assertTrue($renderer->supports(StyleTag::create('content')));
        self::assertTrue($renderer->supports(StyleTag::create('content')));
    }

    /**
     * @test
     */
    public function it_does_not_support_base_tag(): void
    {
        $renderer = self::getCompositeRenderer();

        self::assertFalse($renderer->supports(new BaseTag()));
    }

    /**
     * @test
     */
    public function it_renders(): void
    {
        $renderer = self::getCompositeRenderer();

        self::assertSame('<style>content</style>', $renderer->render(StyleTag::create('content')));
        self::assertSame('<script>content</script>', $renderer->render(InlineScriptTag::create('content')));
    }

    /**
     * @test
     */
    public function it_throws_exception_if_tag_is_not_supported(): void
    {
        $this->expectException(UnsupportedTagException::class);

        $tag = new class() extends Tag {
        };

        $renderer = self::getCompositeRenderer();
        $renderer->render($tag);
    }

    private static function getCompositeRenderer(): CompositeRenderer
    {
        $renderer = new CompositeRenderer();
        $renderer->add(new ElementRenderer());
        $renderer->add(new ContentAwareRenderer());

        return $renderer;
    }
}

final class BaseTag extends Tag
{
}
