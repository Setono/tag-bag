<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag\Rendered;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\ContentAwareTag;
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
