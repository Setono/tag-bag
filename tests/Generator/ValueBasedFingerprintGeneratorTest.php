<?php

declare(strict_types=1);

namespace Setono\TagBag\Generator;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\ContentAwareTag;

/**
 * @covers \Setono\TagBag\Generator\ValueBasedFingerprintGenerator
 */
final class ValueBasedFingerprintGeneratorTest extends TestCase
{
    /**
     * @test
     */
    public function it_generates(): void
    {
        $fingerprint = (new ValueBasedFingerprintGenerator())
            ->generate(ContentAwareTag::create('rendered_value'), 'rendered_value')
        ;

        self::assertSame('5041ecdd6ce733b93561c1c79613f8e1', $fingerprint);
    }
}
