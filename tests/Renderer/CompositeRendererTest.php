<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Exception\UnsupportedTagException;
use Setono\TagBag\Tag\ScriptTag;
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

        self::assertTrue($renderer->supports(new StyleTag('content')));
        self::assertTrue($renderer->supports(new StyleTag('content')));
    }

    /**
     * @test
     */
    public function it_does_not_support_base_tag(): void
    {
        $renderer = self::getCompositeRenderer();

        self::assertFalse($renderer->supports(new class() extends Tag {
        }));
    }

    /**
     * @test
     */
    public function it_renders(): void
    {
        $renderer = self::getCompositeRenderer();

        self::assertSame('<style>content</style>', $renderer->render(new StyleTag('content')));
        self::assertSame('<script>content</script>', $renderer->render(new ScriptTag('content')));
    }

    /**
     * @test
     */
    public function it_throws_exception_if_tag_is_not_supported(): void
    {
        $this->expectException(UnsupportedTagException::class);

        $renderer = self::getCompositeRenderer();
        $renderer->render(new class() extends Tag {
        });
    }

    private static function getCompositeRenderer(): CompositeRenderer
    {
        $renderer = new CompositeRenderer();
        $renderer->addRenderer(new StyleRenderer());
        $renderer->addRenderer(new ScriptRenderer());

        return $renderer;
    }
}
