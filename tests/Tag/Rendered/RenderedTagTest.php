<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag\Rendered;

use Countable;
use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\Tag;
use Setono\TagBag\Tag\TagInterface;

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
        $tag = new class() extends Tag {
        };
        $tag->setPriority(10)->setName('name');

        $renderedTag = RenderedTag::createFromTag($tag, 'value');

        $this->assertInstanceOf(Countable::class, $renderedTag);
        $this->assertSame('name', $renderedTag->getName());
        $this->assertSame('value', $renderedTag->getValue());
        $this->assertSame('value', (string) $renderedTag);
        $this->assertSame(10, $renderedTag->getPriority());
        $this->assertSame(TagInterface::SECTION_BODY_END, $renderedTag->getSection());
        $this->assertCount(1, $renderedTag);
    }
}
