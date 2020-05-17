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
        $tag = new RenderedTag('name', 'value', 10);
        $this->assertInstanceOf(Countable::class, $tag);

        $this->assertSame('name', $tag->getName());
        $this->assertSame('value', $tag->getValue());
        $this->assertSame('value', (string) $tag);
        $this->assertSame(10, $tag->getPriority());
        $this->assertCount(1, $tag);
    }
}
