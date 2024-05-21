<?php

declare(strict_types=1);

namespace Setono\TagBag\Serializer;

use PHPUnit\Framework\TestCase;
use Setono\TagBag\Tag\RenderedTag;

final class CompositeSerializerTest extends TestCase
{
    /**
     * @test
     */
    public function it_serializes(): void
    {
        $serializer = self::getSerializer();
        $data = $serializer->serialize(self::getTags());

        self::assertSame(self::getSerializedJson(), $data);
    }

    /**
     * @test
     */
    public function it_deserializes_json(): void
    {
        $serializer = self::getSerializer();
        $tags = $serializer->deserialize(self::getSerializedJson());

        self::assertEquals(self::getTags(), $tags);
    }

    /**
     * @test
     */
    public function it_deserializes_php(): void
    {
        $serializer = self::getSerializer();
        $tags = $serializer->deserialize(self::getSerializedPhp());

        self::assertEquals(self::getTags(), $tags);
    }

    private static function getSerializer(): SerializerInterface
    {
        $serializer = new CompositeSerializer(new JsonSerializer());

        /** @psalm-suppress DeprecatedClass */
        $serializer->add(new PhpSerializer());

        return $serializer;
    }

    /**
     * @return array<string, list<RenderedTag>>
     */
    private static function getTags(): array
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

    private static function getSerializedJson(): string
    {
        return '{"section1":[{"value":"value1","section":"section1","priority":1,"unique":true,"fingerprint":"fingerprint1"},{"value":"value2","section":"section1","priority":2,"unique":true,"fingerprint":"fingerprint2"}]}';
    }

    private static function getSerializedPhp(): string
    {
        return 'a:1:{s:8:"section1";a:2:{i:0;O:29:"Setono\TagBag\Tag\RenderedTag":5:{s:5:"value";s:6:"value1";s:7:"section";s:8:"section1";s:8:"priority";i:1;s:6:"unique";b:1;s:11:"fingerprint";s:12:"fingerprint1";}i:1;O:29:"Setono\TagBag\Tag\RenderedTag":5:{s:5:"value";s:6:"value2";s:7:"section";s:8:"section1";s:8:"priority";i:2;s:6:"unique";b:1;s:11:"fingerprint";s:12:"fingerprint2";}}}';
    }
}
