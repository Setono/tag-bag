<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Setono\TagBag\Tag\RenderedTag
 */
final class RenderedTagTest extends TestCase
{
    /**
     * @test
     */
    public function it_instantiates(): void
    {
        $tag = ContentAwareTag::create('value')
            ->withName('name')
            ->unique()
        ;

        $renderedTag = RenderedTag::createFromTag($tag, 'value', 'fingerprint');

        self::assertSame('name', $renderedTag->getName());
        self::assertSame('value', $renderedTag->getValue());
        self::assertSame('value', (string) $renderedTag);
        self::assertSame(TagInterface::SECTION_BODY_END, $renderedTag->getSection());
        self::assertTrue($renderedTag->isUnique());
        self::assertSame('fingerprint', $renderedTag->getFingerprint());
    }
}
