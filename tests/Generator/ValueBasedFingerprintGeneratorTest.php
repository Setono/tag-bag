<?php

declare(strict_types=1);

namespace Setono\TagBag\Generator;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\Tag;

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
        $generator = new ValueBasedFingerprintGenerator();
        $fingerprint = $generator->generate(new class() extends Tag {
        }, 'rendered_value');
        $this->assertSame('5041ecdd6ce733b93561c1c79613f8e1', $fingerprint);
    }
}
