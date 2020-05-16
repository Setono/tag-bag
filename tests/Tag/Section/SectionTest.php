<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag\Section;

use Countable;
use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\Rendered\RenderedTag;
use Traversable;

/**
 * @covers \Setono\TagBag\Tag\Section\Section
 */
final class SectionTest extends TestCase
{
    /**
     * @test
     */
    public function it_adds_a_tag(): void
    {
        $section = new Section();
        $section->addTag(new RenderedTag('key', 'value', 0, true));

        $this->assertSame('value', (string) $section);
    }

    /**
     * @test
     */
    public function it_overrides_existing_tag(): void
    {
        $section = new Section();
        $section->addTag(new RenderedTag('key', 'value1', 0, true));
        $section->addTag(new RenderedTag('key', 'value2', 0, true));

        $this->assertSame('value2', (string) $section);
    }

    /**
     * @test
     */
    public function it_does_not_override_existing_tag(): void
    {
        $section = new Section();
        $section->addTag(new RenderedTag('key', 'value1', 0, true));
        $section->addTag(new RenderedTag('key', 'value2', 0, false));

        $this->assertSame('value1value2', (string) $section);
    }

    /**
     * @test
     *
     * The first time a tag is added, it will just be added
     * The second time it will be added by combining the first and second tag in a multi rendered tag
     * Therefore the third time there should be a multi rendered tag present
     */
    public function it_uses_multi_rendered_tag(): void
    {
        $section = new Section();
        $section->addTag(new RenderedTag('key', 'value1', 0, true));
        $section->addTag(new RenderedTag('key', 'value2', 0, false));
        $section->addTag(new RenderedTag('key', 'value3', 0, false));

        $this->assertSame('value1value2value3', (string) $section);
    }

    /**
     * @test
     */
    public function it_prioritizes(): void
    {
        $section = new Section();
        $section->addTag(new RenderedTag('key1', 'value3', -10, true));
        $section->addTag(new RenderedTag('key2', 'value1', 10, true));
        $section->addTag(new RenderedTag('key3', 'value2', 0, true));

        $this->assertSame('value1value2value3', (string) $section);
    }

    /**
     * @test
     */
    public function it_returns_true_if_tag_is_present(): void
    {
        $section = new Section();
        $section->addTag(new RenderedTag('key', 'value', 0, true));

        $this->assertTrue($section->hasTag('key'));
    }

    /**
     * @test
     */
    public function it_counts(): void
    {
        $section = new Section();
        $this->assertInstanceOf(Countable::class, $section);
        $section->addTag(new RenderedTag('key1', 'value3', 0, false));
        $section->addTag(new RenderedTag('key1', 'value1', 0, false));
        $section->addTag(new RenderedTag('key2', 'value2', 0, false));

        $this->assertCount(3, $section);
    }

    /**
     * @test
     */
    public function it_is_traversable(): void
    {
        $section = new Section();
        $this->assertInstanceOf(Traversable::class, $section);

        $section->addTag(new RenderedTag('key1', 'value3', -10, true));
        $section->addTag(new RenderedTag('key2', 'value1', 10, true));
        $section->addTag(new RenderedTag('key3', 'value2', 0, true));

        $expected = ['key2', 'key3', 'key1'];

        $i = 0;
        foreach ($section as $tag) {
            $this->assertSame($expected[$i], $tag->getKey());
            ++$i;
        }
    }
}
