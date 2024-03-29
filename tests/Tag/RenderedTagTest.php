<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

use PHPUnit\Framework\TestCase;

final class RenderedTagTest extends TestCase
{
    /**
     * @test
     */
    public function it_instantiates(): void
    {
        $tag = ContentTag::create('value')
            ->unique()
        ;

        $renderedTag = RenderedTag::createFromTag($tag, 'value', 'fingerprint');

        self::assertSame('value', $renderedTag->value);
        self::assertSame('value', (string) $renderedTag);
        self::assertSame(TagInterface::SECTION_BODY_END, $renderedTag->section);
        self::assertTrue($renderedTag->unique);
        self::assertSame('fingerprint', $renderedTag->fingerprint);
    }
}
