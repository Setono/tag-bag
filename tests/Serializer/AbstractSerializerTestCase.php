<?php

declare(strict_types=1);

namespace Setono\TagBag\Serializer;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\RenderedTag;

abstract class AbstractSerializerTestCase extends TestCase
{
    /**
     * @test
     */
    public function it_serializes(): void
    {
        $serializer = static::getSerializer();
        $data = $serializer->serialize(static::getTags());

        self::assertSame(static::getSerializedString(), $data);
    }

    /**
     * @test
     */
    public function it_deserializes(): void
    {
        $serializer = static::getSerializer();
        $tags = $serializer->deserialize(static::getSerializedString());

        self::assertEquals(static::getTags(), $tags);
    }

    abstract protected static function getSerializer(): SerializerInterface;

    abstract protected static function getSerializedString(): string;

    /**
     * @return array<string, list<RenderedTag>>
     */
    protected static function getTags(): array
    {
        return [
            'section1' => [
                RenderedTag::createFromArray([
                    'value' => 'value1',
                    'section' => 'section1',
                    'priority' => 1,
                    'unique' => true,
                    'fingerprint' => 'fingerprint1',
                ]),
                RenderedTag::createFromArray([
                    'value' => 'value2',
                    'section' => 'section1',
                    'priority' => 2,
                    'unique' => true,
                    'fingerprint' => 'fingerprint2',
                ]),
            ],
        ];
    }
}
