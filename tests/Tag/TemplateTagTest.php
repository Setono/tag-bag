<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

use PHPUnit\Framework\TestCase;

final class TemplateTagTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates(): void
    {
        self::assertInstanceOf(TagInterface::class, TemplateTag::create('template'));
    }

    /**
     * @test
     */
    public function it_has_default_values(): void
    {
        $tag = TemplateTag::create('template.html.twig');

        self::assertSame('template.html.twig', $tag->getTemplate());
        self::assertSame('twig', $tag->getTemplateType());
        self::assertSame([], $tag->getData());
    }
}
