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
        self::assertTrue($renderer->supports(ScriptTag::create('content')));
    }

    /**
     * @test
     */
    public function it_does_not_support_other_tags(): void
    {
        $renderer = new ScriptRenderer();
        self::assertFalse($renderer->supports(new NotAScriptTag()));
    }

    /**
     * @test
     */
    public function it_renders(): void
    {
        $renderer = new ScriptRenderer();
        self::assertSame('<script>content</script>', $renderer->render(ScriptTag::create('content')));
    }

    /**
     * @test
     */
    public function it_renders_with_type(): void
    {
        $tag = ScriptTag::create('content')->withType('application/ld+json');

        $renderer = new ScriptRenderer();
        self::assertSame('<script type="application/ld+json">content</script>', $renderer->render($tag));
    }
}

final class NotAScriptTag extends Tag
{
    public function __construct()
    {
        parent::__construct('setono/not-a-script-tag');
    }
}
