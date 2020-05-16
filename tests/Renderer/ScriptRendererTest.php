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
        $this->assertTrue($renderer->supports(new ScriptTag('key', 'content')));
    }

    /**
     * @test
     */
    public function it_does_not_support_other_tags(): void
    {
        $renderer = new ScriptRenderer();
        $this->assertFalse($renderer->supports(new Tag('key')));
    }

    /**
     * @test
     */
    public function it_renders(): void
    {
        $renderer = new ScriptRenderer();
        $this->assertSame('<script>content</script>', $renderer->render(new ScriptTag('key', 'content')));
    }
}
