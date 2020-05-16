<?php

declare(strict_types=1);

namespace Setono\TagBag\Exception;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Setono\TagBag\Exception\NonExistingTagsException
 */
final class NonExistingTagsExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function it_instantiates(): void
    {
        $exception = new NonExistingTagsException(['tag1', 'tag2']);
        $this->assertSame('The following tags does not exist in the tag bag: tag1, tag2', $exception->getMessage());
    }
}
