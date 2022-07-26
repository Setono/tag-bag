<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

use PHPUnit\Framework\TestCase;

final class ElementTagTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates_with_content(): void
    {
        $tag = ElementTag::createWithContent('div', 'content');
        self::assertSame('div', $tag->getElement());
        self::assertSame('content', $tag->getContent());
        self::assertTrue($tag->hasClosingElement());
    }

    /**
     * @test
     */
    public function it_creates_without_content(): void
    {
        $tag = ElementTag::createWithoutContent('script');
        self::assertSame('script', $tag->getElement());
        self::assertSame('', $tag->getContent());
    }

    /**
     * @test
     */
    public function it_has_immutable_setters(): void
    {
        $tag = ElementTag::createWithContent('div', 'content');
        $newTag = $tag->noClosingElement()->withElement('link');

        self::assertNotSame($tag, $newTag);
        self::assertSame('div', $tag->getElement());
        self::assertSame('content', $tag->getContent());
        self::assertTrue($tag->hasClosingElement());
        self::assertSame('link', $newTag->getElement());
        self::assertFalse($newTag->hasClosingElement());
    }
}
