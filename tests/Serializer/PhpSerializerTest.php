<?php

declare(strict_types=1);

namespace Setono\TagBag\Serializer;

final class PhpSerializerTest extends AbstractSerializerTestCase
{
    protected static function getSerializer(): SerializerInterface
    {
        return new PhpSerializer();
    }

    protected static function getSerializedString(): string
    {
        return 'a:1:{s:8:"section1";a:2:{i:0;O:29:"Setono\TagBag\Tag\RenderedTag":5:{s:5:"value";s:6:"value1";s:7:"section";s:8:"section1";s:8:"priority";i:1;s:6:"unique";b:1;s:11:"fingerprint";s:12:"fingerprint1";}i:1;O:29:"Setono\TagBag\Tag\RenderedTag":5:{s:5:"value";s:6:"value2";s:7:"section";s:8:"section1";s:8:"priority";i:2;s:6:"unique";b:1;s:11:"fingerprint";s:12:"fingerprint2";}}}';
    }
}
