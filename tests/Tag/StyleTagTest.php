<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

use PHPUnit\Framework\TestCase;

final class StyleTagTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates(): void
    {
        $tag = StyleTag::create('content');
        self::assertInstanceOf(TagInterface::class, $tag);
        self::assertInstanceOf(ContentAwareInterface::class, $tag);
        self::assertInstanceOf(AttributesAwareInterface::class, $tag);
    }
}
