<?php

declare(strict_types=1);

namespace Setono\TagBag\Serializer;

final class JsonSerializerTest extends AbstractSerializerTestCase
{
    protected static function getSerializer(): SerializerInterface
    {
        return new JsonSerializer();
    }

    protected static function getSerializedString(): string
    {
        return '{"section1":[{"value":"value1","section":"section1","priority":1,"unique":true,"fingerprint":"fingerprint1"},{"value":"value2","section":"section1","priority":2,"unique":true,"fingerprint":"fingerprint2"}]}';
    }
}
