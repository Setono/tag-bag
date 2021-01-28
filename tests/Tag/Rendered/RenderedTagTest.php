<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag\Rendered;

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
        $tag->setPriority(10)
            ->setName('name')
            ->addDependency('dependency')
            ->setUnique(true)
        ;

        $renderedTag = RenderedTag::createFromTag($tag, 'value', 'fingerprint');

        self::assertSame('name', $renderedTag->getName());
        self::assertSame('value', $renderedTag->getValue());
        self::assertSame('value', (string) $renderedTag);
        self::assertSame(10, $renderedTag->getPriority());
        self::assertSame(TagInterface::SECTION_BODY_END, $renderedTag->getSection());
        self::assertSame(['dependency'], $renderedTag->getDependencies());
        self::assertTrue($renderedTag->isUnique());
        self::assertSame('fingerprint', $renderedTag->getFingerprint());
    }
}
