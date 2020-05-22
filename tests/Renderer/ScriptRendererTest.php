<?php

declare(strict_types=1);

namespace Setono\TagBag\Renderer;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\ScriptTag;
use Setono\TagBag\Tag\Tag;

/**
 * @covers \Setono\TagBag\Renderer\ScriptRenderer
 */
final class ScriptRendererTest extends TestCase
{
    /**
     * @test
     */
    public function it_supports_script_tag(): void
    {
        $renderer = new ScriptRenderer();
        $this->assertTrue($renderer->supports(new ScriptTag('content')));
    }

    /**
     * @test
     */
    public function it_does_not_support_other_tags(): void
    {
        $renderer = new ScriptRenderer();
        $this->assertFalse($renderer->supports(new class() extends Tag {
        }));
    }

    /**
     * @test
     */
    public function it_renders(): void
    {
        $renderer = new ScriptRenderer();
        $this->assertSame('<script>content</script>', $renderer->render(new ScriptTag('content')));
    }

    /**
     * @test
     */
    public function it_renders_with_type(): void
    {
        $tag = new ScriptTag('content');
        $tag->setType('application/ld+json');

        $renderer = new ScriptRenderer();
        $this->assertSame('<script type="application/ld+json">content</script>', $renderer->render($tag));
    }
}
