<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag\Rendered;

use Countable;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Setono\TagBag\Tag\Rendered\RenderedTag
 */
final class RenderedTagTest extends TestCase
{
    /**
     * @test
     */
    public function it_instantiates(): void
    {
        $tag = new RenderedTag('key', 'value', 10, true);
        $this->assertInstanceOf(Countable::class, $tag);

        $this->assertSame('key', $tag->getKey());
        $this->assertSame('value', $tag->getValue());
        $this->assertSame('value', (string) $tag);
        $this->assertSame(10, $tag->getPriority());
        $this->assertTrue($tag->willReplace());
        $this->assertCount(1, $tag);
    }
}
