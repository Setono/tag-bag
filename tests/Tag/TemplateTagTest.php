<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Setono\TagBag\Tag\TemplateTag
 */
final class TemplateTagTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates(): void
    {
        self::assertInstanceOf(TagInterface::class, new TemplateTag('template'));
    }

    /**
     * @test
     */
    public function it_has_default_values(): void
    {
        $tag = new TemplateTag('template');

        self::assertSame('setono_tag_bag_template_tag', $tag->getName());
        self::assertSame('template', $tag->getTemplate());
        self::assertSame([], $tag->getContext());
    }

    /**
     * @test
     */
    public function it_is_mutable(): void
    {
        $tag = new TemplateTag('template');
        $tag->setContext(['key' => 'val']);

        self::assertSame(['key' => 'val'], $tag->getContext());
    }
}
