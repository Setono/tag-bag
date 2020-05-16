<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag\Rendered;

use Countable;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Setono\TagBag\Tag\Rendered\MultiRenderedTag
 */
final class MultiRenderedTagTest extends TestCase
{
    /**
     * @test
     */
    public function it_instantiates(): void
    {
        $tag = self::getTag();

        $this->assertInstanceOf(Countable::class, $tag);
        $this->assertInstanceOf(RenderedTagInterface::class, $tag);

        $tags = $tag->getTags();
        $this->assertIsArray($tags);
        $this->assertCount(3, $tags);

        foreach ($tags as $subTag) {
            $this->assertInstanceOf(RenderedTagInterface::class, $subTag);
            $this->assertInstanceOf(RenderedTag::class, $subTag);
        }
    }

    /**
     * @test
     */
    public function it_stringifies(): void
    {
        $tag = self::getTag();

        $this->assertSame('value2value1value3', (string) $tag);
    }

    /**
     * @test
     */
    public function it_sorts(): void
    {
        $tag = self::getTag();

        $this->assertSame('value2value1value3', $tag->getValue());
    }

    /**
     * @test
     */
    public function it_sets_the_correct_priority(): void
    {
        $tag = self::getTag();

        $this->assertSame(10, $tag->getPriority());
    }

    /**
     * @test
     */
    public function it_counts(): void
    {
        $tag = self::getTag();

        $this->assertCount(3, $tag);
    }

    private static function getTag(): MultiRenderedTag
    {
        $tag1 = new RenderedTag('key', 'value1', 0, true);
        $tag2 = new RenderedTag('key', 'value2', 10, true);
        $tag3 = new RenderedTag('key', 'value3', -10, true);

        return new MultiRenderedTag($tag1, $tag2, $tag3);
    }
}
